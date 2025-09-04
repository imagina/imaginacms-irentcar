<?php

namespace Modules\Irentcar\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Imagina\Icore\Models\CoreModel;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Office extends CoreModel
{

  protected $table = 'irentcar__offices';
  public string $transformer = 'Modules\Irentcar\Transformers\OfficeTransformer';
  public string $repository = 'Modules\Irentcar\Repositories\OfficeRepository';
  public array $requestValidation = [
    'create' => 'Modules\Irentcar\Http\Requests\CreateOfficeRequest',
    'update' => 'Modules\Irentcar\Http\Requests\UpdateOfficeRequest',
  ];
  //Instance external/internal events to dispatch with extraData
  public array $dispatchesEventsWithBindings = [
    'created' => [['path' => 'Modules\Ilocation\Events\CreateLocation']],
    'creating' => [],
    'updated' => [['path' => 'Modules\Ilocation\Events\UpdateLocation']],
    'updating' => [],
    'deleting' => [['path' => 'Modules\Ilocation\Events\DeleteLocation']],
    'deleted' => []
  ];
  public array $translatedAttributes = [];
  protected $fillable = [
    'title',
    'description',
    'status_id'
  ];

  protected $appends = [
    'status'
  ];

  public function status(): Attribute
  {
    return Attribute::get(function () {
      $status = new Status();
      return $status->show($this->status_id);
    });
  }

  public function gammas(): BelongsToMany
  {
    return $this->belongsToMany(Gamma::class, 'irentcar__gamma_office')
      ->withPivot('id', 'office_id', 'gamma_id', 'quantity', 'price')
      ->withTimestamps();
  }

  /**
   * Locatable Implementation
   */
  public function locatable()
  {
    if (isModuleEnabled('Ilocation')) {
      return app(\Modules\Ilocation\Relations\LocationsRelation::class)->resolve($this);
    }
    return new \Imagina\Icore\Relations\EmptyRelation();
  }
}
