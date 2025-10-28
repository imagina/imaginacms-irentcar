<?php

namespace Modules\Irentcar\Services;

use Modules\Irentcar\Repositories\GammaOfficeRepository;
use Modules\Irentcar\Repositories\GammaRepository;
use Modules\Irentcar\Repositories\GammaOfficeExtraRepository;
use Modules\Irentcar\Repositories\DailyAvailabilityRepository;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Symfony\Component\HttpFoundation\Response;
use Exception;

use Modules\Irentcar\Models\ReservationStatus;
use Modules\Irentcar\Models\DailyAvailability;

use Modules\Irentcar\Support\PriceHelper;

class ReservationService
{
    private $gammaOfficeRepository;
    private $gammaRepository;
    private $gammaOfficeExtraRepository;
    private $dailyAvailabilityRepository;

    private $gammaOffice;

    public function __construct(
        GammaOfficeRepository $gammaOfficeRepository,
        GammaRepository $gammaRepository,
        GammaOfficeExtraRepository $gammaOfficeExtraRepository,
        DailyAvailabilityRepository $dailyAvailabilityRepository
    ) {
        $this->gammaOfficeRepository = $gammaOfficeRepository;
        $this->gammaRepository = $gammaRepository;
        $this->gammaOfficeExtraRepository = $gammaOfficeExtraRepository;
        $this->dailyAvailabilityRepository  = $dailyAvailabilityRepository;
    }

    /**
     * Used by ReservationRepository (BeforeCreate)
     * Get Attributes to create a Reservation
     * @param mixed $data
     */
    public function getDataToCreate($data, $isPreview = false)
    {

        if (!$isPreview) {
            $this->validationsUser($data);
        }
        $this->getGammaData($data);
        $this->getPriceFromGammaOffice($data);
        $this->getExtrasData($data);
        $this->getTotalPrice($data);
        $this->getConvertionsData($data);

        //Not preview
        if (!$isPreview) {
            $this->processToDailyAvailabilities($data);
            $this->setDefaultStatus($data);
        }

        return $data;
    }

    /**
     * Get user and validate age
     */
    private function validationsUser(&$data)
    {
        //Get User
        $user = \Auth::user();
        //Configration from Setting
        $ageSetting = setting("irentcar::minDriveAge");

        //Get age from User
        $age = $user->age ?? null;

        //Validation Aage
        if (is_null($age) || $age < $ageSetting) {
            throw new \Exception(
                itrans('irentcar::reservation.validation.minimunUserAge', ['age' => $ageSetting]),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        //Set user id
        $data['user_id'] = $user->id;
    }

    /**
     * Get price from gammaOffice and priority in DailyAvailability
     * Get Tax from gamma Office
     */
    private function getPriceFromGammaOffice(&$data)
    {

        $gammaOfficeId = $data['gamma_office_id'];
        $pickupDate = Carbon::parse($data['pickup_date'])->format('Y-m-d');

        //Priority check in dailyAvailability to this specific Date and this gamma_office_id
        $params = [
            'filter' => [
                'field' => 'available_date',
                'gamma_office_id' => $gammaOfficeId
            ]
        ];
        $dailyAvailability = $this->dailyAvailabilityRepository->getItem($pickupDate, json_decode(json_encode($params)));

        //To specific date get the price
        if ($dailyAvailability && !is_null($dailyAvailability->price)) {
            $data['gamma_office_price'] = $dailyAvailability->price;
        } else {
            //Get Base price
            $data['gamma_office_price'] = $this->gammaOffice->price;
        }

        //Get Tax
        $data['gamma_office_tax'] = $this->gammaOffice->tax;
    }

    /**
     * Get gammaOffice, get gamma and set data
     */
    private function getGammaData(&$data)
    {
        //Get Gamma Office with Gamma and DailyAvailabilities
        $params = ['include' => ['gamma', 'dailyAvailabilities']];
        $this->gammaOffice = $this->gammaOfficeRepository->getItem($data['gamma_office_id'], json_decode(json_encode($params)));

        $gamma = $this->gammaOffice->gamma->toArray();

        //Set gamma data
        $data['gamma_id'] = $gamma['id'];
        //Save data as backup
        $data['gamma_data'] = $gamma;
    }

    /**
     * OPTIONAL Get Extras data and total price to the extras
     */
    private function getExtrasData(&$data)
    {
        if (isset($data['gamma_office_extra_ids'])) {
            //Ids to array
            $ids =  $data['gamma_office_extra_ids'];

            //Params to Query
            $params = [
                'filter' => ['id' => $ids],
                'include' => ['extra']
            ];

            $totalPrice = 0;
            $extras = [];

            $extrasBD = $this->gammaOfficeExtraRepository->getItemsBy(json_decode(json_encode($params)));

            foreach ($extrasBD as $key => $extra) {
                $extras[$key] = $extra->toArray();
                $totalPrice += $extra->price;
            }

            //
            //Final Data
            $data['extras_data'] = $extras;
            $data['gamma_office_extra_total_price'] = $totalPrice;
        }
    }

    /**
     * Get total price from gamma Office price + extras total price
     * Get Rental Days
     */
    private function getTotalPrice(&$data)
    {
        $totalPrice = $data['gamma_office_price'];

        //Validation to add extra total price
        if (isset($data['gamma_office_extra_total_price']))
            $totalPrice += $data['gamma_office_extra_total_price'];

        $pickup = Carbon::parse($data['pickup_date']);
        $dropoff = Carbon::parse($data['dropoff_date']);

        if ($dropoff->greaterThan($pickup)) {
            $hours = $pickup->diffInHours($dropoff);
            //Redondea hacia arriba apenas exist aun decimal
            $days = ceil($hours / 24);
            // Siempre sumar 1 día adicional por el día de pickup
            //$days += 1;
        } else {
            throw new Exception(itrans('irentcar::reservation.validation.dropoff date must be greater than pickup date'), Response::HTTP_CONFLICT);
        }

        $data['rental_days'] = (int)$days;
        $data['total_price'] = $totalPrice * $data['rental_days'];
    }

    /**
     * Get Convertion Rates
     */
    private function getConvertionsData(&$data)
    {

        $result = getConversionRates();

        if (isset($result['USDRates'])) {
            $data['options']['USDRates'] = $result['USDRates'];
        }
    }

    /**
     * Resevation Default Status
     */
    private function setDefaultStatus(&$data)
    {
        $data["status_id"] = 1; //ReservationStatus APPROVED
    }

    /**
     * Process to DailyAvailabilities: Create or Update reserved_quantity
     */
    private function processToDailyAvailabilities(array &$data): void
    {
        $pickupDate = Carbon::parse($data['pickup_date'])->startOfDay();
        $dropoffDate = Carbon::parse($data['dropoff_date'])->startOfDay();

        //Global Gamma Office
        $gammaOffice = $this->gammaOffice;

        //Iterar por cada día del rango segun la reserva
        $period = CarbonPeriod::create($pickupDate, $dropoffDate);
        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');

            //Buscar si ya existe disponibilidad para ese día
            $daily = $gammaOffice->dailyAvailabilities->first(function ($item) use ($dateKey) {
                return Carbon::parse($item->available_date)->format('Y-m-d') === $dateKey;
            });

            if ($daily) {
                // Ya existe: incrementar reserved_quantity
                $newReserved = $daily->reserved_quantity + 1;
                $this->dailyAvailabilityRepository->updateBy(
                    $daily->id,
                    ['reserved_quantity' => $newReserved]
                );
            } else {
                // No existe: crear nuevo registro con algunos datos del padre
                $this->dailyAvailabilityRepository->create([
                    'gamma_office_id'    => $gammaOffice->id,
                    'quantity'           => $gammaOffice->quantity,
                    'available_date'     => $dateKey,
                    'reserved_quantity'  => 1,
                    'reason'             => null,
                    'price'              => $gammaOffice->price
                ]);
            }
        }
    }

    /**
     * Process Before Update Reservation
     */
    public function processBeforeUpdate($model, $data)
    {
        //Get Cancelled Status
        $cancelledStatus = ReservationStatus::CANCELLED;

        if ($model->status_id == $cancelledStatus)
            throw new Exception(itrans('irentcar::reservation.validation.The reservation has already been cancelled'), Response::HTTP_CONFLICT);
    }
    /**
     * Process After Update Reservation
     */
    public function processAfterUpdate($model, $data)
    {

        if (!setting("irentcar::updateDailyAvailabilitiesAfterCancelReservation")) {
            return;
        }

        //Get Cancelled Status
        $cancelledStatus = ReservationStatus::CANCELLED;

        //Only if the status was changed to CANCELLED.
        if ($model->status_id == $cancelledStatus) {

            //Get availabilities only in this range and apply keyBy
            // keyBy transforma la colección en un array asociativo usando la fecha como clave,
            $dailyAvailabilities = DailyAvailability::where('gamma_office_id', $model->gamma_office_id)
                ->whereBetween('available_date', [
                    Carbon::parse($model->pickup_date)->toDateString(),
                    Carbon::parse($model->dropoff_date)->toDateString()
                ])
                ->get()
                ->keyBy(fn($item) => Carbon::parse($item->available_date)->toDateString());

            //Create a period with Dates
            $period = CarbonPeriod::create(
                Carbon::parse($model->pickup_date)->startOfDay(),
                Carbon::parse($model->dropoff_date)->startOfDay()
            );

            foreach ($period as $date) {
                $dateKey = $date->format('Y-m-d');
                $daily = $dailyAvailabilities[$dateKey] ?? null;

                if ($daily && $daily->reserved_quantity > 0) {
                    $newReserved = $daily->reserved_quantity - 1;

                    $this->dailyAvailabilityRepository->updateBy(
                        $daily->id,
                        [
                            'reserved_quantity' => $newReserved
                        ]
                    );
                }
            }
        }
    }
}
