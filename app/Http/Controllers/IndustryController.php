<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIndustryRequest;
use App\Http\Requests\UpdateIndustryRequest;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Industry;
use App\Repositories\IndustryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndustryController extends AppBaseController
{
    /** @var IndustryRepository */
    private $industryRepository;

    public function __construct(IndustryRepository $industryRepo)
    {
        $this->industryRepository = $industryRepo;
    }

    /**
     * Display a listing of the Industry.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('industries.index');
    }

    /**
     * Store a newly created Industry in storage.
     */
    public function store(CreateIndustryRequest $request): JsonResponse
    {
        $input = $request->all();
        $industry = $this->industryRepository->create($input);

        return $this->sendResponse($industry, __('messages.flash.industry_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry): JsonResponse
    {
        return $this->sendResponse($industry, 'Industry Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified Industry.
     */
    public function show(Industry $industry): JsonResponse
    {
        return $this->sendResponse($industry, 'Industry Retrieved Successfully.');
    }

    /**
     * Update the specified Industry in storage.
     */
    public function update(UpdateIndustryRequest $request, Industry $industry): JsonResponse
    {
        $input = $request->all();
        $this->industryRepository->update($input, $industry->id);

        return $this->sendSuccess(__('messages.flash.industry_update'));
    }

    /**
     * Remove the specified Industry from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Industry $industry): JsonResponse
    {
        $Models = [
            Candidate::class,
            Company::class,
        ];
        $result = canDelete($Models, 'industry_id', $industry->id);
        if ($result) {
            return $this->sendError(__('messages.flash.industry_cant_delete'));
        }
        $industry->delete();

        return $this->sendSuccess(__('messages.flash.industry_delete'));
    }
}
