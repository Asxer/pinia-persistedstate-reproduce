<?php

namespace App\Repositories;

use App\Models\Country;

/**
 * @property Country $model
 */
class CountryRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Country::class);
    }
}
