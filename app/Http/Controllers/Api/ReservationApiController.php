<?php

namespace Modules\Irentcar\Http\Controllers\Api;

use Imagina\Icore\Http\Controllers\CoreApiController;

//Model
use Modules\Irentcar\Models\Reservation;
use Modules\Irentcar\Repositories\ReservationRepository;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

use Imagina\Icore\Traits\Controller\CoreApiControllerHelpers;
use Modules\Irentcar\Services\ValidationDateService;

use Modules\Irentcar\Services\GammaService;
use Modules\Irentcar\Transformers\GammaTransformer;

use Modules\Irentcar\Services\ReservationService;
use Imagina\Icore\Transformers\CoreResource;
use Modules\Irentcar\Support\PriceHelper;

class ReservationApiController extends CoreApiController
{
  use CoreApiControllerHelpers;

  public function __construct(Reservation $model, ReservationRepository $modelRepository)
  {
    parent::__construct($model, $modelRepository);
  }

  /**
   * Validation Dates (Previo Reservation)
   * @return mixed
   */
  public function validationDate(Request $request, ValidationDateService $validationDateService): JsonResponse
  {
    try {

      //Get Parameters from request
      $params = $this->getParamsRequest($request);
      $filters = (array)$params->filter;
      //Validate Request
      $this->validateWithModelRules($filters, 'validationDate');

      $result = $validationDateService->init($filters);

      //Response
      $response = ['data' => $result];
    } catch (Exception $e) {
      [$status, $response] = $this->getErrorResponse($e);
    }

    //Return response
    return response()->json($response, $status ?? Response::HTTP_OK);
  }

  /**
   * Available Gammas (Previo Reservation)
   * @return mixed
   */
  public function getAvailableGammas(Request $request, GammaService $gammaService): JsonResponse
  {
    try {

      //Get Parameters from request
      $params = $this->getParamsRequest($request);
      $filters = (array)$params->filter;

      //Validate Request
      $this->validateWithModelRules($filters, 'validationGammasToReservation');

      //Process to get gammas
      $gammas = $gammaService->getGammasToReservations($filters, $params);

      //Response
      $response = ['data' => GammaTransformer::collection($gammas)];

      if ($params->page) $response['meta'] = ['page' => $this->pageTransformer($gammas)];
    } catch (Exception $e) {
      [$status, $response] = $this->getErrorResponse($e);
    }

    //Return response
    return response()->json($response, $status ?? Response::HTTP_OK);
  }

  /**
   * Get Preview data to save a Reservation
   */
  public function getPreviewReservation(Request $request, ReservationService $reservationService): JsonResponse
  {
    try {

      //Get Parameters from request
      $params = $this->getParamsRequest($request);

      //Get Data
      $modelData = $request->input('attributes') ?? [];

      //Validate Request
      $this->validateWithModelRules($modelData, 'create');

      //Important: This service is also invoked during the reservation creation process.
      $dataToSave = $reservationService->getDataToCreate($modelData);

      //Add conversion to USD
      $dataToSave['total_price_usd'] = PriceHelper::getTotalPriceInUsd($dataToSave['options'], $dataToSave['total_price']);

      //Final Response
      $response = ['data' => CoreResource::transformData($dataToSave)];

      //Response
      $response = ['data' => $dataToSave];
    } catch (Exception $e) {
      [$status, $response] = $this->getErrorResponse($e);
    }

    //Return response
    return response()->json($response, $status ?? Response::HTTP_OK);
  }
}
