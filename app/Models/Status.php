<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreStaticModel;

class Status extends CoreStaticModel
{
  const INACTIVE = 0;

  const ACTIVE = 1;

  public function __construct()
  {
    $this->records = [
      self::INACTIVE => [
        'id' => self::INACTIVE,
        'title' => itrans('irentcar::office.status.inactive')
      ],
      self::ACTIVE => [
        'id' => self::ACTIVE,
        'title' => itrans('irentcar::office.status.active')
      ],
    ];
  }
}
