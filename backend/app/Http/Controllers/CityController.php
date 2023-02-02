<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cities\CreateCityRequest;
use App\Http\Requests\Cities\UpdateCityRequest;
use App\Http\Requests\Cities\DeleteCityRequest;
use App\Http\Requests\Cities\GetCityRequest;
use App\Http\Requests\Cities\SearchCitiesRequest;
use App\Services\CityService;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function create(CreateCityRequest $request, CityService $service)
    {
        $data = $request->onlyValidated();

        $result = $service->create($data);

        return response()->json($result);
    }

    public function get(GetCityRequest $request, CityService $service, $id)
    {
        $result = $service
            ->with($request->input('with', []))
            ->withCount($request->input('with_count', []))
            ->find($id);

        return response()->json($result);
    }

    public function search(SearchCitiesRequest $request, CityService $service)
    {
        $result = $service->search($request->onlyValidated());

        return response()->json($result);
    }

    public function update(UpdateCityRequest $request, CityService $service, $id)
    {
        $service->update($id, $request->onlyValidated());

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function delete(DeleteCityRequest $request, CityService $service, $id)
    {
        $service->delete($id);

        return response('', Response::HTTP_NO_CONTENT);
    }

}
