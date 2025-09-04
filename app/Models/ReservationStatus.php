<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreStaticModel;

class ReservationStatus extends CoreStaticModel
{
    const PENDING = 0;

    const APPROVED = 1;
    const CANCELLED = 2;
    const FINISHED = 3;

    public function __construct()
    {
        $this->records = [
            self::PENDING => [
                'id' => self::PENDING,
                'title' => itrans('irentcar::reservation.status.pending'),
            ],
            self::APPROVED => [
                'id' => self::APPROVED,
                'title' => itrans('irentcar::reservation.status.approved'),
            ],
            self::CANCELLED => [
                'id' => self::CANCELLED,
                'title' => itrans('irentcar::reservation.status.cancelled'),
            ],
            self::FINISHED => [
                'id' => self::FINISHED,
                'title' => itrans('irentcar::reservation.status.finished'),
            ],
        ];
    }
}
