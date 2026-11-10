<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use App\Models\Job;
use App\Models\State;
use App\Repositories\CountryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CountryController extends AppBaseController
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|Response|View
     */
    public function index(): View
    {
        return view('countries.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCountryRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['short_code'] = strtoupper($input['short_code']);
        $country = $this->countryRepository->create($input);

        return $this->sendResponse($country, __('messages.flash.country_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country): JsonResponse
    {
        return $this->sendResponse($country, __('messages.flash.retrieved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country): JsonResponse
    {
        $input = $request->all();
        $input['short_code'] = strtoupper($input['short_code']);

        $this->countryRepository->update($input, $country->id);

        return $this->sendSuccess(__('messages.flash.country_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws \Exception
     */
    public function destroy(Country $country): JsonResponse
    {
        if (State::where('country_id', $country->id)->count() > 0) {
            return $this->sendError(__('messages.flash.country_cant_delete'));
        }
        if (Job::whereCountryId($country->id)->count() > 0) {
            return $this->sendError(__('messages.flash.country_cant_delete'));
        }
        $country->delete();

        return $this->sendSuccess(__('messages.flash.country_delete'));
    }
}
