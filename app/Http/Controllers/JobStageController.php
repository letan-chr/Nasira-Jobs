<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobStageRequest;
use App\Http\Requests\UpdateJobStageRequest;
use App\Models\JobApplication;
use App\Models\JobApplicationSchedule;
use App\Models\JobStage;
use App\Repositories\JobStageRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobStageController extends AppBaseController
{
    /** @var JobStageRepository */
    private $jobStageRepository;

    public function __construct(JobStageRepository $jobStageRepository)
    {
        $this->jobStageRepository = $jobStageRepository;
    }

    /**
     * Display a listing of the JobType.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('employer.job_stages.index');
    }

    /**
     * Store a newly created JobType in storage.
     */
    public function store(CreateJobStageRequest $request): JsonResponse
    {
        $input = $request->all();
        $jobStageExists = JobStage::whereName($input['name'])
            ->where('company_id', '=', getLoggedInUser()->owner_id)
            ->exists();
        if ($jobStageExists) {
            return $this->sendError('The name has already been taken');
        }
        $input['company_id'] = getLoggedInUser()->owner_id;
        $this->jobStageRepository->create($input);

        return $this->sendSuccess(__('messages.flash.job_stage_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobStage $jobStage): JsonResponse
    {
        $companyId = getLoggedInUser()->company->id;
        $jobStageId = JobStage::whereCompanyId($companyId)->pluck('id')->toArray();

        if (! in_array($jobStage->id, $jobStageId)) {
            return $this->sendError(__('messages.common.seems_message'));
        }

        return $this->sendResponse($jobStage, 'Job Stage Retrieved Successfully.');
    }

    /**
     * Update the specified JobStage in storage.
     */
    public function update(UpdateJobStageRequest $request, JobStage $jobStage): JsonResponse
    {
        $companyId = getLoggedInUser()->company->id;
        $jobStageId = JobStage::whereCompanyId($companyId)->pluck('id')->toArray();

        if (! in_array($jobStage->id, $jobStageId)) {
            return $this->sendError(__('messages.common.seems_message'));
        }

        $input = $request->all();
        $jobStageExists = JobStage::whereName($input['name'])
            ->whereCompanyId(getLoggedInUser()->owner_id)
            ->where('id', '!=', $input['jobStageId'])->exists();
        if ($jobStageExists) {
            return $this->sendError(__('messages.flash.the_name_has'));
        }
        $this->jobStageRepository->update($input, $jobStage->id);

        return $this->sendSuccess(__('messages.flash.job_stage_update'));
    }

    /**
     * Show the form for editing the specified JobStage.
     */
    public function show(JobStage $jobStage): JsonResponse
    {
        $companyId = getLoggedInUser()->company->id;
        $jobStageId = JobStage::whereCompanyId($companyId)->pluck('id')->toArray();

        if (! in_array($jobStage->id, $jobStageId)) {
            return $this->sendError(__('messages.common.seems_message'));
        }

        return $this->sendResponse($jobStage, __('messages.flash.job_stage_retrieve'));
    }

    /**
     * Remove the specified JobStage from storage.
     */
    public function destroy(JobStage $jobStage): JsonResponse
    {
        $companyId = getLoggedInUser()->company->id;
        $jobStageId = JobStage::whereCompanyId($companyId)->pluck('id')->toArray();

        if (! in_array($jobStage->id, $jobStageId)) {
            return $this->sendError(__('messages.common.seems_message'));
        }

        $jobModels = [
            JobApplication::class,
        ];
        $result = canDelete($jobModels, 'job_stage_id', $jobStage->id);
        $jobScheduleModels = [
            JobApplicationSchedule::class,
        ];
        $jobScheduleResult = canDelete($jobScheduleModels, 'stage_id', $jobStage->id);
        if ($result) {
            return $this->sendError(__('messages.flash.job_stage_cant_delete'));
        }
        if ($jobScheduleResult) {
            return $this->sendError(__('messages.flash.job_stage_cant_delete'));
        }

        $jobStage->delete();

        return $this->sendSuccess(__('messages.flash.job_stage_delete'));
    }
}
