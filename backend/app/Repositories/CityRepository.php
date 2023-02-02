<?php

namespace App\Repositories;

use App\Models\City;

/**
 * @property City $model
 */
class CityRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(City::class);
    }
}
