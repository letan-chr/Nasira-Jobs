<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaritalStatusRequest;
use App\Http\Requests\UpdateMaritalStatusRequest;
use App\Models\Candidate;
use App\Models\MaritalStatus;
use App\Repositories\MaritalStatusRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaritalStatusController extends AppBaseController
{
    /** @var MaritalStatusRepository */
    private $maritalStatusRepository;

    public function __construct(MaritalStatusRepository $maritalStatusRepo)
    {
        $this->maritalStatusRepository = $maritalStatusRepo;
    }

    /**
     * Display a listing of the MaritalStatus.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('marital_status.index');
    }

    /**
     * Store a newly created MaritalStatus in storage.
     */
    public function store(CreateMaritalStatusRequest $request): JsonResponse
    {
        $input = $request->all();
        $maritalStatus = $this->maritalStatusRepository->create($input);

        return $this->sendResponse($maritalStatus, __('messages.flash.marital_status_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(MaritalStatus $maritalStatus): JsonResponse
    {
        return $this->sendResponse($maritalStatus, __('messages.flash.marital_status_retrieve'));
    }

    /**
     * Show the form for editing the specified MaritalStatus.
     */
    public function edit(MaritalStatus $maritalStatus): JsonResponse
    {
        return $this->sendResponse($maritalStatus, 'Marital Status Retrieved Successfully.');
    }

    /**
     * Update the specified MaritalStatus in storage.
     */
    public function update(UpdateMaritalStatusRequest $request, MaritalStatus $maritalStatus): JsonResponse
    {
        $input = $request->all();
        $this->maritalStatusRepository->update($input, $maritalStatus->id);

        return $this->sendSuccess(__('messages.flash.marital_status_update'));
    }

    /**
     * Remove the specified MaritalStatus from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(MaritalStatus $maritalStatus): JsonResponse
    {
        $candidateModels = [
            Candidate::class,
        ];
        $result = canDelete($candidateModels, 'marital_status_id', $maritalStatus->id);
        if ($result) {
            return $this->sendError(__('messages.marital_status.marital_status_cant_delete'));
        }
        $maritalStatus->delete();

        return $this->sendSuccess(__('messages.flash.marital_status_delete'));
    }
}
