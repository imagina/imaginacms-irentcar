<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreStaticModel;

class VehicleType extends CoreStaticModel
{
  const AUTOMOBILE = 0;

  const PICKUP = 1;

  public function __construct()
  {
    $this->records = [
      self::AUTOMOBILE => [
        'id' => self::AUTOMOBILE,
        'title' => itrans('irentcar::gamma.vehicleType.automobile')
      ],
      self::PICKUP => [
        'id' => self::PICKUP,
        'title' => itrans('irentcar::gamma.vehicleType.pickup')
      ],
    ];
  }
}
