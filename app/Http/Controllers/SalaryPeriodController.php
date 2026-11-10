<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalaryPeriodRequest;
use App\Http\Requests\UpdateSalaryPeriodRequest;
use App\Models\Job;
use App\Models\SalaryPeriod;
use App\Repositories\SalaryPeriodRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryPeriodController extends AppBaseController
{
    /** @var SalaryPeriodRepository */
    private $salaryPeriodRepository;

    public function __construct(SalaryPeriodRepository $salaryPeriodRepo)
    {
        $this->salaryPeriodRepository = $salaryPeriodRepo;
    }

    /**
     * Display a listing of the SalaryPeriod.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('salary_periods.index');
    }

    /**
     * Store a newly created SalaryPeriod in storage.
     */
    public function store(CreateSalaryPeriodRequest $request): JsonResponse
    {
        $input = $request->all();
        $salaryPeriod = $this->salaryPeriodRepository->create($input);

        return $this->sendResponse($salaryPeriod, __('messages.flash.salary_period_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalaryPeriod $salaryPeriod): JsonResponse
    {
        return $this->sendResponse($salaryPeriod, 'Salary Period Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified SalaryPeriod.
     */
    public function show(SalaryPeriod $salaryPeriod): JsonResponse
    {
        return $this->sendResponse($salaryPeriod, __('messages.flash.salary_period_retrieve'));
    }

    /**
     * Update the specified SalaryPeriod in storage.
     */
    public function update(UpdateSalaryPeriodRequest $request, SalaryPeriod $salaryPeriod): JsonResponse
    {
        $input = $request->all();
        $this->salaryPeriodRepository->update($input, $salaryPeriod->id);

        return $this->sendSuccess(__('messages.flash.salary_period_update'));
    }

    /**
     * Remove the specified SalaryPeriod from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(SalaryPeriod $salaryPeriod): JsonResponse
    {
        $jobModels = [
            Job::class,
        ];
        $result = canDelete($jobModels, 'salary_period_id', $salaryPeriod->id);
        if ($result) {
            return $this->sendError(__('messages.flash.salary_period_cant_delete'));
        }
        $salaryPeriod->delete();

        return $this->sendSuccess(__('messages.flash.salary_period_delete'));
    }
}
