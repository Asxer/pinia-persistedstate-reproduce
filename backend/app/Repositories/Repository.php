<?php

namespace App\Repositories;
use Artel\Support\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Repository extends BaseRepository
{
    const DEFAULT_RADIUS = 10;

    public function filterByList(string $field, ?string $filterName = null): self
    {
        if (!empty($this->filter[$filterName])) {
            $this->query->whereIn($field, $this->filter[$filterName]);
        }

        return $this;
    }

    public function filterExceptList(string $field, ?string $filterName = null): self
    {
        if (!empty($this->filter[$filterName])) {
            $this->query->whereNotIn($field, $this->filter[$filterName]);
        }

        return $this;
    }

    public function filterByAllIncluded(string $field, ?string $filterName = null): self
    {
        if (!empty($this->filter[$filterName])) {
            $values = join(',', array_map(function ($value) {
                return "'{$value}'";
            }, $this->filter[$filterName]));

            $this->query->whereRaw("array[{$values}] <@ {$field}::text[]");
        }

        return $this;
    }

    public function filterByAtLeastOne(string $field, ?string $filterName = null): self
    {
        if (!empty($this->filter[$filterName])) {
            $values = join(',', array_map(function ($value) {
                return "'{$value}'";
            }, $this->filter[$filterName]));

            $this->query->whereRaw("{$field}::text[] && array[{$values}]");
        }

        return $this;
    }

    public function filterByFullTextQuery($priorityFields = [])
    {
        if (!empty($this->filter['query'])) {
            $query = $this->clearSearchQuery($this->filter['query']);
            $similarityQuery = $this->buildSimilarityQuery($query, $priorityFields);

            $this->query->where(function ($subQuery) use ($query, $similarityQuery) {
                $subQuery
                    ->whereRaw("search_vector @@ to_tsquery('{$this->generateTsQuery($query)}')")
                    ->orWhereRaw("$similarityQuery > 0.15");
            });

            $this->query->orderBy(
                DB::raw($similarityQuery),
                'desc'
            );
        }

        return $this;
    }

    public function filterByCoordinates($latField = 'latitude', $lngField = 'longitude'): self {
        if (!empty($this->filter['latitude']) && !empty($this->filter['longitude'])) {
            $radius = Arr::get($this->filter, 'radius', self::DEFAULT_RADIUS);

                // Explanation: https://gis.stackexchange.com/a/66673
            $distanceQuery = "(
                6371 * acos (
                    cos ( radians({$this->filter['latitude']}) )
                        * cos( radians( {$latField} ) )
                        * cos( radians( {$lngField} ) - radians({$this->filter['longitude']}) )
                        + sin ( radians({$this->filter['latitude']}) )
                        * sin( radians( {$latField} )
                    )
                )
            )";

            $this->query->addSelect(['*', DB::raw("{$distanceQuery} as distance")]);

            $this->query->where(DB::raw($distanceQuery), '<' , $radius);
        }

        return $this;
    }

    protected function clearSearchQuery($query)
    {
        $specialCharacters = [
            '(', ')', '<', '>', '[', ']', '&', '\'', '"', '@', '#', '%', '%', ':', ';', '.', ',', '*', '`', '~'
        ];

        return str_replace($specialCharacters, ' ', $query);
    }

    protected function generateTsQuery($query)
    {
        $query = $this->clearSearchQuery($query);

        $explodedQuery = array_filter(explode(' ', $query));

        $prefixedQuery = array_map(function ($word) {
            return $word . ':*';
        }, $explodedQuery);

        return implode(' & ', $prefixedQuery);
    }

    protected function buildSimilarityQuery(string $query, array $priorityFields): string
    {
        $conditions = [
            "similarity('{$query}', cast(search_vector as varchar))"
        ];

        foreach ($priorityFields as $index => $field) {
            $multiplier = count($priorityFields) - $index + 1;

            $conditions[] = "similarity('{$query}', {$field}) * {$multiplier}";
        }

        return join(' + ', $conditions);
    }
}