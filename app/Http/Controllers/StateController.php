<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Job;
use App\Models\State;
use App\Repositories\StateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class StateController extends AppBaseController
{
    /**
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|Response|View
     */
    public function index(): View
    {
        $countries = Country::orderBy('name')->pluck('name', 'id');

        return view('states.index', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStateRequest $request): JsonResponse
    {
        $input = $request->all();
        $state = $this->stateRepository->create($input);

        return $this->sendResponse($state, __('messages.flash.state_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state): JsonResponse
    {
        return $this->sendResponse($state, 'State successfully retrieved.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state): JsonResponse
    {
        $input = $request->all();
        $this->stateRepository->update($input, $state->id);

        return $this->sendSuccess(__('messages.flash.state_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws \Exception
     */
    public function destroy(State $state): JsonResponse
    {
        if (City::where('state_id', $state->id)->count() > 0) {
            return $this->sendError(__('messages.flash.state_cant_delete'));
        }
        if (Job::where('state_id', $state->id)->count() > 0) {
            return $this->sendError(__('messages.flash.state_cant_delete'));
        }

        $state->delete();

        return $this->sendSuccess(__('messages.flash.state_delete'));
    }
}
