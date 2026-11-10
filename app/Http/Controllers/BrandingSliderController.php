<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandingSliderRequest;
use App\Models\BrandingSliders;
use App\Repositories\BrandingSliderRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandingSliderController extends AppBaseController
{
    /** @var BrandingSliderRepository */
    private $brandingSliderRepository;

    public function __construct(BrandingSliderRepository $brandingSliderRepository)
    {
        $this->brandingSliderRepository = $brandingSliderRepository;
    }

    /**
     * Display a listing of the BrandingSlider.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('branding_sliders.index');
    }

    /**
     * Store a newly created BrandingSlider in storage.
     */
    public function store(CreateBrandingSliderRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->brandingSliderRepository->store($input);

        return $this->sendSuccess(__('messages.flash.brand_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrandingSliders $brandingSlider): JsonResponse
    {
        return $this->sendResponse($brandingSlider, __('messages.flash.brand_retrieved'));
    }

    /**
     * Update the specified BrandingSlider in storage.
     */
    public function update(Request $request, BrandingSliders $brandingSlider): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:150',
            'branding_slider' => 'nullable|mimes:jpeg,jpg,png',
        ]);
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->brandingSliderRepository->updateBranding($input, $brandingSlider->id);

        return $this->sendSuccess(__('messages.flash.brand_update'));
    }

    /**
     * Remove the specified BrandingSlider from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(BrandingSliders $brandingSlider): JsonResponse
    {
        $brandingSlider->delete();

        return $this->sendSuccess(__('messages.flash.brand_delete'));
    }

    /**
     * @return mixed
     */
    public function changeIsActive(BrandingSliders $brandingSlider)
    {
        $isActive = $brandingSlider->is_active;
        $brandingSlider->update(['is_active' => ! $isActive]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }
}
