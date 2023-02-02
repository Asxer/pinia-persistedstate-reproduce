<?php

namespace App\Http\Requests\Cities;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\CityService;
use App\Http\Requests\Request;

class UpdateCityRequest extends Request
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

        $service = app(CityService::class);

        if (!$service->exists($this->route('id'))) {
            throw new NotFoundHttpException(__('validation.exceptions.not_found', ['entity' => 'City']));
        }
    }
}
