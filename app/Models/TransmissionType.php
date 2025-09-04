<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreStaticModel;

class TransmissionType extends CoreStaticModel
{
  const MANUAL = 0;

  const AUTOMATIC = 1;

  public function __construct()
  {
    $this->records = [
      self::MANUAL => [
        'id' => self::MANUAL,
        'title' => itrans('irentcar::gamma.transmissionType.manual'),
      ],
      self::AUTOMATIC => [
        'id' => self::AUTOMATIC,
        'title' => itrans('irentcar::gamma.transmissionType.automatic'),
      ],
    ];
  }
}
