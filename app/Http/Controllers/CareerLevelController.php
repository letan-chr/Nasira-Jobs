<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCareerLevelRequest;
use App\Http\Requests\UpdateCareerLevelRequest;
use App\Models\Candidate;
use App\Models\CareerLevel;
use App\Models\Job;
use App\Repositories\CareerLevelRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerLevelController extends AppBaseController
{
    /** @var CareerLevelRepository */
    private $careerLevelRepository;

    public function __construct(CareerLevelRepository $careerLevelRepo)
    {
        $this->careerLevelRepository = $careerLevelRepo;
    }

    /**
     * Display a listing of the CareerLevel.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(): View
    {
        return view('career_levels.index');
    }

    /**
     * Store a newly created CareerLevel in storage.
     */
    public function store(CreateCareerLevelRequest $request): JsonResponse
    {
        $input = $request->all();
        $careerLevel = $this->careerLevelRepository->create($input);

        return $this->sendResponse($careerLevel, __('messages.flash.career_level_save'));
    }

    /**
     * Show the form for editing the specified CareerLevel.
     */
    public function edit(CareerLevel $careerLevel): JsonResponse
    {
        return $this->sendResponse($careerLevel, __('messages.flash.career_level_retrieved'));
    }

    /**
     * Update the specified CareerLevel in storage.
     */
    public function update(UpdateCareerLevelRequest $request, CareerLevel $careerLevel): JsonResponse
    {
        $input = $request->all();
        $this->careerLevelRepository->update($input, $careerLevel->id);

        return $this->sendSuccess(__('messages.flash.career_level_update'));
    }

    /**
     * Remove the specified CareerLevel from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(CareerLevel $careerLevel): JsonResponse
    {
        $Models = [
            Candidate::class,
            Job::class,
        ];
        $result = canDelete($Models, 'career_level_id', $careerLevel->id);
        if ($result) {
            return $this->sendError(__('messages.flash.career_level_cant_delete'));
        }
        $careerLevel->delete();

        return $this->sendSuccess(__('messages.flash.career_level_delete'));
    }
}
