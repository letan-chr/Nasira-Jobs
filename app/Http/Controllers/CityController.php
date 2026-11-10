<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Models\Job;
use App\Models\State;
use App\Repositories\CityRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CityController extends AppBaseController
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|Response|View
     */
    public function index(): View
    {
        $states = State::toBase()->orderBy('name')->pluck('name', 'id');

        return view('cities.index', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCityRequest $request): JsonResponse
    {
        $input = $request->all();
        $state = $this->cityRepository->create($input);

        return $this->sendResponse($state, __('messages.flash.city_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): JsonResponse
    {
        return $this->sendResponse($city, __('messages.flash.city_retrieved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city): JsonResponse
    {
        $input = $request->all();
        $this->cityRepository->update($input, $city->id);

        return $this->sendSuccess(__('messages.flash.city_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws \Exception
     */
    public function destroy(City $city): JsonResponse
    {
        if (Job::whereCityId($city->id)->count() > 0) {
            return $this->sendError(__('messages.flash.city_cant_delete'));
        }
        $city->delete();

        return $this->sendSuccess(__('messages.flash.city_delete'));
    }
}
