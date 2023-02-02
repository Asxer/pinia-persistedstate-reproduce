<?php

namespace App\Http\Requests\Cities;

use App\Http\Requests\Request;

class CreateCityRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'string|required',
        ];
    }
}
