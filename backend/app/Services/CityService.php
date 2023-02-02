<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Artel\Support\Services\EntityService;
use App\Repositories\CityRepository;

/**
 * @mixin CityRepository
 * @property CityRepository $repository
 */
class CityService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(CityRepository::class);
    }

    public function search($filters)
    {
        return $this
            ->with(Arr::get($filters, 'with', []))
            ->withCount(Arr::get($filters, 'with_count', []))
            ->searchQuery($filters)
            ->filterByQuery(['name'])
            ->getSearchResults();
    }
}
