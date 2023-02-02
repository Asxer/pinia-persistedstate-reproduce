<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Artel\Support\Services\EntityService;
use App\Repositories\CountryRepository;

/**
 * @mixin CountryRepository
 * @property CountryRepository $repository
 */
class CountryService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(CountryRepository::class);
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
