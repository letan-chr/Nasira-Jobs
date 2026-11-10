<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHeaderSliderRequest;
use App\Models\HeaderSlider;
use App\Models\Setting;
use App\Repositories\HeaderSliderRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class HeaderSliderController
 */
class HeaderSliderController extends AppBaseController
{
    /** @var HeaderSliderRepository */
    private $headerSliderRepository;

    /**
     * HeaderSliderController constructor.
     */
    public function __construct(HeaderSliderRepository $headerSliderRepository)
    {
        $this->headerSliderRepository = $headerSliderRepository;
    }

    /**
     * Display a listing of the ImageSlider.
     *
     * @param  Request  $request
     * @return Factory|View|Application
     *
     * @throws Exception
     */
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('header_sliders.index', compact('settings'));
    }

    /**
     * Store a newly created ImageSlider in storage.
     */
    public function store(CreateHeaderSliderRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->headerSliderRepository->store($input);

        return $this->sendSuccess(__('messages.flash.header_slider_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeaderSlider $headerSlider): JsonResponse
    {
        return $this->sendResponse($headerSlider, 'Header Slider retrieved successfully.');
    }

    /**
     * Update the specified ImageSlider in storage.
     */
    public function update(Request $request, HeaderSlider $headerSlider): JsonResponse
    {
        $input = $request->all();
        $request->validate([
            'image_slider' => 'nullable|mimes:jpeg,jpg,png',
        ],
            [
                'image_slider.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            ]);

        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->headerSliderRepository->updateHeaderSlider($input, $headerSlider->id);

        return $this->sendSuccess(__('messages.flash.header_slider_update'));
    }

    /**
     * Remove the specified ImageSlider from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(HeaderSlider $headerSlider): JsonResponse
    {
        $headerSlider->delete();

        return $this->sendSuccess(__('messages.flash.header_slider_deleted'));
    }

    /**
     * @return mixed
     */
    public function changeIsActive(HeaderSlider $headerSlider)
    {
        $isActive = $headerSlider->is_active;
        $headerSlider->update(['is_active' => ! $isActive]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }

    /***
     * @return mixed
     */
    public function changeSearchDisable()
    {
        /** @var Setting $setting */
        $setting = Setting::where('key', 'slider_is_active')->first();
        $setting->update(['value' => ! $setting->value]);

        return $this->sendSuccess(__('messages.flash.status_change'));
//        return $this->sendSuccess('This functionality not allowed in demo.');
    }
}
