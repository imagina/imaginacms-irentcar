<?php

namespace Modules\Irentcar\Http\Controllers\Api;

use Imagina\Icore\Http\Controllers\CoreApiController;
//Model
use Modules\Irentcar\Models\DailyAvailability;
use Modules\Irentcar\Repositories\DailyAvailabilityRepository;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Imagina\Icore\Transformers\CoreResource;
use Imagina\Icore\Traits\Controller\CoreApiControllerHelpers;
use Symfony\Component\HttpFoundation\Response;

use Carbon\Carbon;

class DailyAvailabilityApiController extends CoreApiController
{
  use CoreApiControllerHelpers;

  public function __construct(DailyAvailability $model, DailyAvailabilityRepository $modelRepository)
  {
    parent::__construct($model, $modelRepository);
  }

  public function create(Request $request): JsonResponse
  {
    DB::beginTransaction();
    try {
      //Get model data
      $modelData = $request->input('attributes') ?? [];

      //Validate Request
      $this->validateWithModelRules($modelData, 'create');

      if (isset($modelData['end_date']) && !empty($modelData['end_date'])) {

        $start = Carbon::parse($modelData['available_date']);
        $end = Carbon::parse($modelData['end_date']);
        $createdModels = [];
        //Create models for date range
        for ($date = $start; $date->lte($end); $date->addDay()) {
          $modelData['available_date'] = $date->format('Y-m-d');

          //Create model for each date
          $createdModels[] = $this->modelRepository->create($modelData);
        }
        //Get first created model to response
        $model = $createdModels[0];
      } else {
        //Create model
        $model = $this->modelRepository->create($modelData);
      }
      //Response
      $response = ['data' => CoreResource::transformData($model)];
      DB::commit(); //Commit to Data Base
    } catch (Exception $e) {
      DB::rollback(); //Rollback to Data Base
      [$status, $response] = $this->getErrorResponse($e);
    }
    //Return response
    return response()->json($response, $status ?? Response::HTTP_CREATED);
  }

  /**
   * Update OR Create
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateOrCreate(Request $request): JsonResponse
  {
    DB::beginTransaction();
    try {
      //Get model data
      $modelData = $request->input('attributes') ?? [];

      //Validate Request
      $this->validateWithModelRules($modelData, 'create');

      //Criteria to
      $criteria = [
        'gamma_office_id' => $modelData['gamma_office_id']
      ];

      if (isset($modelData['end_date']) && !empty($modelData['end_date'])) {
        $start = Carbon::parse($modelData['available_date']);
        $end = Carbon::parse($modelData['end_date']);

        //Create models for date range
        for ($date = $start; $date->lte($end); $date->addDay()) {
          $modelData['available_date'] = $date->format('Y-m-d');

          $criteria['available_date'] = $modelData['available_date'];
          //Create Or Update model
          $model = $this->modelRepository->UpdateOrCreate($criteria, $modelData);
        }
      } else {
        //Create Or Update model
        $criteria['available_date'] = $modelData['available_date'];
        $model = $this->modelRepository->UpdateOrCreate($criteria, $modelData);
      }


      //Response
      $response = ['data' => CoreResource::transformData($model)];
      DB::commit(); //Commit to Data Base
    } catch (Exception $e) {
      DB::rollback(); //Rollback to Data Base
      [$status, $response] = $this->getErrorResponse($e);
    }
    //Return response
    return response()->json($response, $status ?? Response::HTTP_OK);
  }
}
