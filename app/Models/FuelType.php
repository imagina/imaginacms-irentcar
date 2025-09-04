<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreStaticModel;

class FuelType extends CoreStaticModel
{
  const GASOLINE = 0;

  const DIESEL = 1;

  public function __construct()
  {
    $this->records = [
      self::GASOLINE => [
        'id' => self::GASOLINE,
        'title' => itrans('irentcar::gamma.fuelType.gasoline')
      ],
      self::DIESEL => [
        'id' => self::DIESEL,
        'title' => itrans('irentcar::gamma.fuelType.diesel')
      ],
    ];
  }
}
