<?php

namespace App\Http\Requests\Countries;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\CountryService;
use App\Http\Requests\Request;

class UpdateCountryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        $service = app(CountryService::class);

        if (!$service->exists($this->route('id'))) {
            throw new NotFoundHttpException(__('validation.exceptions.not_found', ['entity' => 'Country']));
        }
    }
}
