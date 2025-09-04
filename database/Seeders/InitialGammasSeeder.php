<?php

namespace Modules\Irentcar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Irentcar\Models\Gamma;

class InitialGammasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (Gamma::count() === 0) {
      $gammas = [
        [
          'title' => 'Gama ZX',
          'summary' => 'Kia Picanto o Similar',
          'description' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit',
          'passengers_number' => 3,
          'luggage' => 1,
          'doors' => 2,
          'transmission_type_id' => 0,
          'fuel_type_id' => 0,
          'vehicle_type_id' => 0,
        ],
        [
          'title' => 'Gama AB',
          'summary' => 'Fiat Pulse o Similar',
          'description' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit',
          'passengers_number' => 5,
          'luggage' => 1,
          'doors' => 4,
          'transmission_type_id' => 1,
          'fuel_type_id' => 1,
          'vehicle_type_id' => 1,
        ]
      ];

      //Create gammas
      $repository = app('Modules\Irentcar\Repositories\GammaRepository');
      foreach ($gammas as $data) {
        $gamma = $repository->create($data);
      }
    }
  }
}
