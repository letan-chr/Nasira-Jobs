<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Repositories\JobCategoryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobCategoryController extends AppBaseController
{
    /** @var JobCategoryRepository */
    private $jobCategoryRepository;

    public function __construct(JobCategoryRepository $jobCategoryRepo)
    {
        $this->jobCategoryRepository = $jobCategoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        $featured = JobCategory::FEATURED;
        $jobCategories = JobCategory::all();

        return view('job_categories.index', compact('featured', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(CreateJobCategoryRequest $request)
    {
        $input = $request->all();
        $jobCategory = $this->jobCategoryRepository->store($input);

        return $this->sendResponse($jobCategory, __('messages.flash.job_category_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $jobCategory): JsonResponse
    {
        return $this->sendResponse($jobCategory, 'Job Category Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(JobCategory $jobCategory): JsonResponse
    {
        return $this->sendResponse($jobCategory, 'Job Category Retrieved Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(UpdateJobCategoryRequest $request, JobCategory $jobCategory)
    {
        $input = $request->all();

        $this->jobCategoryRepository->updateJobCategory($input, $jobCategory->id);

        return $this->sendSuccess(__('messages.flash.job_category_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(JobCategory $jobCategory): JsonResponse
    {
        $jobModels = [
            Job::class,
        ];
        $result = canDelete($jobModels, 'job_category_id', $jobCategory->id);
        if ($result) {
            return $this->sendError(__('messages.flash.job_category_cant_delete'));
        }
        $jobCategory->delete();

        return $this->sendSuccess(__('messages.flash.job_category_delete'));
    }

    /**
     * @return mixed
     */
    public function changeStatus(JobCategory $jobCategory)
    {
        $isFeatured = $jobCategory->is_featured;
        $jobCategory->update(['is_featured' => ! $isFeatured]);

        return $this->sendSuccess(__('messages.flash.status_change'));
    }
}
