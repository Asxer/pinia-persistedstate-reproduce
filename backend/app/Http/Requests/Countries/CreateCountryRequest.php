<?php

namespace App\Http\Requests\Countries;

use App\Http\Requests\Request;

class CreateCountryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'string|required',
        ];
    }
}
