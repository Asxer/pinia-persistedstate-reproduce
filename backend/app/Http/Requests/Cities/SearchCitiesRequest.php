<?php

namespace App\Http\Requests\Cities;

use App\Http\Requests\Request;

class SearchCitiesRequest extends Request
{
    public function rules(): array
    {
        return [
            'page' => 'integer',
            'per_page' => 'integer',
            'all' => 'integer',
            'order_by' => 'string',
            'desc' => 'boolean',
            'with' => 'array',
            'query' => 'string|nullable',
            'with.*' => 'string|required',
        ];
    }
}
