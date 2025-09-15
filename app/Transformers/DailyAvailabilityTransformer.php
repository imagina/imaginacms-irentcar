<?php

namespace Modules\Irentcar\Transformers;

use Imagina\Icore\Transformers\CoreResource;

use Modules\Irentcar\Support\PriceHelper;

class DailyAvailabilityTransformer extends CoreResource
{
  /**
   * Attribute to exclude relations from transformed data
   * @var array
   */
  protected array $excludeRelations = [];

  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request): array
  {
    return [
      'priceConversions' => PriceHelper::getPriceConversions($this->price)
    ];
  }
}
