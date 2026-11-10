<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageSliderRequest;
use App\Models\ImageSlider;
use App\Models\Setting;
use App\Repositories\ImageSliderRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImageSliderController extends AppBaseController
{
    /** @var ImageSliderRepository */
    private $imageSliderRepository;

    public function __construct(ImageSliderRepository $imageSliderRepo)
    {
        $this->imageSliderRepository = $imageSliderRepo;
    }

    /**
     * Display a listing of the ImageSlider.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('image_sliders.index', compact('settings'));
    }

    /**
     * Store a newly created ImageSlider in storage.
     */
    public function store(CreateImageSliderRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->imageSliderRepository->store($input);

        return $this->sendSuccess(__('messages.flash.image_slider_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageSlider $imageSlider): JsonResponse
    {
        return $this->sendResponse($imageSlider, 'Image Slider retrieved successfully.');
    }

    /**
     * Update the specified ImageSlider in storage.
     */
    public function update(Request $request, ImageSlider $imageSlider): JsonResponse
    {
        $input = $request->all();
        $request->validate([
            'image_slider' => 'nullable|mimes:jpeg,jpg,png',
        ],
            [
                'image_slider.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            ]);
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->imageSliderRepository->updateImageSlider($input, $imageSlider->id);

        return $this->sendSuccess(__('messages.flash.image_slider_update'));
    }

    /**
     * Remove the specified ImageSlider from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(ImageSlider $imageSlider): JsonResponse
    {
        $imageSlider->delete();

        return $this->sendSuccess(__('messages.flash.image_slider_delete'));
    }

    /**
     * @return mixed
     */
    public function changeIsActive(ImageSlider $imageSlider)
    {
        $isActive = $imageSlider->is_active;
        $imageSlider->update(['is_active' => ! $isActive]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }

    /**
     * @return mixed
     */
    public function changeFullSlider()
    {
        /** @var Setting $setting */
        $setting = Setting::where('key', 'is_full_slider')->first();
        $setting->update(['value' => ! $setting->value]);

        return $this->sendSuccess(__('messages.flash.status_change'));
    }

    /**
     * @return mixed
     */
    public function changeSliderActive()
    {
        /** @var Setting $setting */
        $setting = Setting::where('key', 'is_slider_active')->first();
        $setting->update(['value' => ! $setting->value]);

        return $this->sendSuccess(__('messages.flash.status_change'));
//        return $this->sendSuccess('This functionality not allowed in demo.');
    }

    /**
     * Show the form for editing the specified ImageSlider.
     */
    public function show(ImageSlider $imageSlider): JsonResponse
    {
        return $this->sendResponse($imageSlider, __('messages.flash.image_slider_retrieve'));
    }
}
