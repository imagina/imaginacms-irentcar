<?php

namespace Modules\Irentcar\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Imagina\Icore\Models\CoreModel;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Gamma extends CoreModel
{

  protected $table = 'irentcar__gammas';
  public string $transformer = 'Modules\Irentcar\Transformers\GammaTransformer';
  public string $repository = 'Modules\Irentcar\Repositories\GammaRepository';
  public array $requestValidation = [
    'create' => 'Modules\Irentcar\Http\Requests\CreateGammaRequest',
    'update' => 'Modules\Irentcar\Http\Requests\UpdateGammaRequest',
  ];
  //Instance external/internal events to dispatch with extraData
  public array $dispatchesEventsWithBindings = [
    'created' => [['path' => 'Modules\Imedia\Events\CreateMedia']],
    'creating' => [],
    'updated' => [['path' => 'Modules\Imedia\Events\UpdateMedia']],
    'updating' => [],
    'deleting' => [['path' => 'Modules\Imedia\Events\DeleteMedia']],
    'deleted' => []
  ];
  public array $translatedAttributes = [];
  protected $fillable = [
    'title',
    'description',
    'summary',
    'transmission_type_id',
    'passengers_number',
    'luggage',
    'doors',
    'fuel_type_id',
    'vehicle_type_id',
    'next_gamma_id',
    'options'
  ];

  protected function casts(): array
  {
    return [
      'options' => 'json'
    ];
  }

  protected $appends = [
    'transmission_type',
    'fuel_type',
    'vehicle_type'
  ];

  public array $mediaFillable = [
    'mainimage' => 'single'
  ];


  //TODO - Duda de como funciona esto, si es necesario o no
  /* public $modelRelations = [
      'gammaOffices' => [
          'relation' => 'belongsToMany',
          'type' => 'updateOrCreateMany',
          'compareKeys' => ['office_id'], // Esto para que era?
          'model' => 'Modules\Irentcar\Models\GammaOffice',
      ]
  ]; */

  /**
   * Attribute Static Class
   */
  public function transmissionType(): Attribute
  {
    return Attribute::get(function () {
      $transmissionType = new TransmissionType();
      return $transmissionType->show($this->transmission_type_id);
    });
  }

  /**
   * Attribute Static Class
   */
  public function fuelType(): Attribute
  {
    return Attribute::get(function () {
      $fuelType = new FuelType();
      return $fuelType->show($this->fuel_type_id);
    });
  }

  /**
   * Attribute Static Class
   */
  public function vehicleType(): Attribute
  {
    return Attribute::get(function () {
      $vehiculeType = new VehicleType();
      return $vehiculeType->show($this->vehicle_type_id);
    });
  }

  /**
   * Relations
   */
  public function nextGamma(): BelongsTo
  {
    return $this->belongsTo(Gamma::class, 'next_gamma_id');
  }

  public function offices(): BelongsToMany
  {
    return $this->belongsToMany(Office::class, 'irentcar__gamma_office')
      ->withPivot('id', 'office_id', 'gamma_id', 'quantity', 'price')
      ->withTimestamps();
  }

  /**
   * Relation Media
   * Make the Many To Many Morph
   */
  public function files()
  {
    if (isModuleEnabled('Imedia')) {
      return app(\Modules\Imedia\Relations\FilesRelation::class)->resolve($this);
    }
    return new \Imagina\Icore\Relations\EmptyRelation();
  }
}
