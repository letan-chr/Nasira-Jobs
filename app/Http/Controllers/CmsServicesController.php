<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutusRequest;
use App\Http\Requests\CmsServiceRequest;
use App\Models\CmsServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class CmsServicesController extends AppBaseController
{
    public function index(Request $request): \Illuminate\View\View
    {
        $cmsServices = CmsServices::pluck('value', 'key')->toArray();

        return view('cms_services.index', compact('cmsServices'));
    }

    /**
     * @return Application|Factory|View
     */
    public function aboutUsService(Request $request): \Illuminate\View\View
    {
        $cmsServices = CmsServices::pluck('value', 'key')->toArray();

        return view('cms_services.about-us', compact('cmsServices'));
    }

    public function update(CmsServiceRequest $request): RedirectResponse
    {
        $input = $request->all();
        $inputArr = Arr::except($input, ['_token']);
        foreach ($inputArr as $key => $value) {
            /** @var CmsServices $cmsServices */
            $cmsServices = CmsServices::where('key', $key)->first();
            if (! $cmsServices) {
                continue;
            }

            if (in_array($key, ['home_banner']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);

                continue;
            }

            $cmsServices->update(['value' => $value]);
        }
        Flash::success(__('messages.flash.cms_service_update'));
//        Flash::success('This functionality not allowed in demo.');

        return Redirect::back();
    }

    public function aboutUsUpdate(AboutusRequest $request): RedirectResponse
    {
        $input = $request->all();
        $inputArr = Arr::except($input, ['_token']);
        foreach ($inputArr as $key => $value) {
            /** @var CmsServices $cmsServices */
            $cmsServices = CmsServices::where('key', $key)->first();
            if (! $cmsServices) {
                continue;
            }

            if (in_array($key, ['about_image_one']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);

                continue;
            }
            if (in_array($key, ['about_image_two']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);

                continue;
            }
            if (in_array($key, ['about_image_three']) && ! empty($value)) {
                $this->fileUpload($cmsServices, $value);

                continue;
            }

            $cmsServices->update(['value' => $value]);
        }
        Flash::success(__('messages.flash.about_us_update'));

        return Redirect::back();
    }

    public function fileUpload($cmsServices, $file)
    {
        $cmsServices->clearMediaCollection(CmsServices::PATH);
        $media = $cmsServices->addMedia($file)->toMediaCollection(CmsServices::PATH, config('app.media_disc'));
        $cmsServices->update(['value' => $media->getFullUrl()]);

        return $cmsServices;
    }
}
