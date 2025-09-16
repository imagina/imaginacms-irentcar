<?php

namespace Modules\Irentcar\Models;

use Imagina\Icore\Models\CoreModel;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Irentcar\Support\PriceHelper;

class DailyAvailability extends CoreModel
{


  protected $table = 'irentcar__daily_availabilities';
  public string $transformer = 'Modules\Irentcar\Transformers\DailyAvailabilityTransformer';
  public string $repository = 'Modules\Irentcar\Repositories\DailyAvailabilityRepository';
  public array $requestValidation = [
    'create' => 'Modules\Irentcar\Http\Requests\CreateDailyAvailabilityRequest',
    'update' => 'Modules\Irentcar\Http\Requests\UpdateDailyAvailabilityRequest',
  ];
  //Instance external/internal events to dispatch with extraData
  public array $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public array $translatedAttributes = [];
  protected $fillable = [
    'gamma_office_id',
    'quantity',
    'available_date',
    'reason',
    'price',
    'reserved_quantity'
  ];

  protected $appends = [
    'price_conversions'
  ];

  protected function casts(): array
  {
    return [
      'price' => 'int'
    ];
  }

  public function priceConversions(): Attribute
  {
    return Attribute::get(function () {
      return PriceHelper::getPriceConversions($this->price);
    });
  }

  /*
   * Relationships
   */
  public function gammaOffice()
  {
    return $this->belongsTo(GammaOffice::class);
  }
}
