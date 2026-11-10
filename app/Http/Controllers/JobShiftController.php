<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobShiftRequest;
use App\Http\Requests\UpdateJobShiftRequest;
use App\Models\Job;
use App\Models\JobShift;
use App\Repositories\JobShiftRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobShiftController extends AppBaseController
{
    /** @var JobShiftRepository */
    private $jobShiftRepository;

    public function __construct(JobShiftRepository $jobShiftRepo)
    {
        $this->jobShiftRepository = $jobShiftRepo;
    }

    /**
     * Display a listing of the JobShift.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('job_shifts.index');
    }

    /**
     * Store a newly created JobShift in storage.
     */
    public function store(CreateJobShiftRequest $request): JsonResponse
    {
        $input = $request->all();
        $jobShift = $this->jobShiftRepository->create($input);

        return $this->sendResponse($jobShift, __('messages.flash.job_shift_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobShift $jobShift): JsonResponse
    {
        return $this->sendResponse($jobShift, 'Job Shift Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified JobShift.
     */
    public function show(JobShift $jobShift): JsonResponse
    {
        return $this->sendResponse($jobShift, __('messages.flash.job_shift_retrieve'));
    }

    /**
     * Update the specified JobShift in storage.
     */
    public function update(UpdateJobShiftRequest $request, JobShift $jobShift): JsonResponse
    {
        $input = $request->all();
        $this->jobShiftRepository->update($input, $jobShift->id);

        return $this->sendSuccess(__('messages.flash.job_shift_update'));
    }

    /**
     * Remove the specified JobShift from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(JobShift $jobShift): JsonResponse
    {
        $jobModels = [
            Job::class,
        ];
        $result = canDelete($jobModels, 'job_shift_id', $jobShift->id);
        if ($result) {
            return $this->sendError(__('messages.flash.job_shift_cant_delete'));
        }
        $jobShift->delete();

        return $this->sendSuccess(__('messages.flash.job_shift_delete'));
    }
}
