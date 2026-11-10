<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOwnerShipTypeRequest;
use App\Http\Requests\UpdateOwnerShipTypeRequest;
use App\Models\Company;
use App\Models\OwnerShipType;
use App\Repositories\OwnerShipTypeRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerShipTypeController extends AppBaseController
{
    /** @var OwnerShipTypeRepository */
    private $ownerShipTypeRepository;

    public function __construct(OwnerShipTypeRepository $ownerShipTypeRepo)
    {
        $this->ownerShipTypeRepository = $ownerShipTypeRepo;
    }

    /**
     * Display a listing of the OwnerShipType.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('ownership_types.index');
    }

    /**
     * Store a newly created OwnerShipType in storage.
     */
    public function store(CreateOwnerShipTypeRequest $request): JsonResponse
    {
        $input = $request->all();

        $ownerShipType = $this->ownerShipTypeRepository->create($input);

        return $this->sendResponse($ownerShipType, __('messages.flash.ownership_type_save'));
    }

    /**
     * Display the specified OwnerShipType.
     */
    public function show(OwnerShipType $ownerShipType): JsonResponse
    {
        return $this->sendResponse($ownerShipType, __('messages.flash.ownership_type_retrieve'));
    }

    /**
     * Show the form for editing the specified OwnerShipType.
     */
    public function edit(OwnerShipType $ownerShipType): JsonResponse
    {
        return $this->sendResponse($ownerShipType, 'OwnerShip Type retrieved successfully.');
    }

    /**
     * Update the specified OwnerShipType in storage.
     */
    public function update(OwnerShipType $ownerShipType, UpdateOwnerShipTypeRequest $request): JsonResponse
    {
        $ownerShipType = $this->ownerShipTypeRepository->update($request->all(), $ownerShipType->id);

        return $this->sendSuccess(__('messages.flash.ownership_type_updated'));
    }

    /**
     * Remove the specified OwnerShipType from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(OwnerShipType $ownerShipType): JsonResponse
    {
        $companyModels = [
            Company::class,
        ];
        $result = canDelete($companyModels, 'ownership_type_id', $ownerShipType->id);
        if ($result) {
            return $this->sendError(__('messages.flash.ownership_type_cant_delete'));
        }
        $this->ownerShipTypeRepository->delete($ownerShipType->id);

        return $this->sendSuccess(__('messages.flash.ownership_type_delete'));
    }
}
