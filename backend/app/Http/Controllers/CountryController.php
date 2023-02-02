<?php

namespace App\Http\Controllers;

use App\Http\Requests\Countries\CreateCountryRequest;
use App\Http\Requests\Countries\UpdateCountryRequest;
use App\Http\Requests\Countries\DeleteCountryRequest;
use App\Http\Requests\Countries\GetCountryRequest;
use App\Http\Requests\Countries\SearchCountriesRequest;
use App\Services\CountryService;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    public function create(CreateCountryRequest $request, CountryService $service)
    {
        $data = $request->onlyValidated();

        $result = $service->create($data);

        return response()->json($result);
    }

    public function get(GetCountryRequest $request, CountryService $service, $id)
    {
        $result = $service
            ->with($request->input('with', []))
            ->withCount($request->input('with_count', []))
            ->find($id);

        return response()->json($result);
    }

    public function search(SearchCountriesRequest $request, CountryService $service)
    {
        $result = $service->search($request->onlyValidated());

        return response()->json($result);
    }

    public function update(UpdateCountryRequest $request, CountryService $service, $id)
    {
        $service->update($id, $request->onlyValidated());

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function delete(DeleteCountryRequest $request, CountryService $service, $id)
    {
        $service->delete($id);

        return response('', Response::HTTP_NO_CONTENT);
    }

}
