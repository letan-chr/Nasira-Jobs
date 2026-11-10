<?php

namespace App\Http\Controllers;

use App\Models\FrontSetting;
use App\Models\SalaryCurrency;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class FrontSettingsController extends AppBaseController
{
    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $currencies = SalaryCurrency::pluck('currency_name', 'id');
        $frontSettings = FrontSetting::pluck('value', 'key')->toArray();

        return view('front_settings.index', compact('frontSettings', 'currencies'));
    }

    public function update(Request $request): RedirectResponse
    {
        $inputArr = $request->all();

        $request->validate([
            'advertise_image' => 'nullable|mimes:jpeg,jpg,png',
        ]);

        $inputArr = Arr::except($inputArr, ['_token']);

        (isset($inputArr['featured_jobs_enable'])) ? $inputArr['featured_jobs_enable'] = 1 : $inputArr['featured_jobs_enable'] = 0;
        (isset($inputArr['featured_companies_enable'])) ? $inputArr['featured_companies_enable'] = 1 : $inputArr['featured_companies_enable'] = 0;
        (isset($inputArr['latest_jobs_enable'])) ? $inputArr['latest_jobs_enable'] = 1 : $inputArr['latest_jobs_enable'] = 0;

        if ($inputArr['featured_jobs_enable'] == FrontSetting::FEATURED_JOBS_ENABLED) {
            if (isset($inputArr['featured_jobs_price']) && empty($inputArr['featured_jobs_price'])) {
                Flash::error(__('messages.flash.feature_job_price'));

                return Redirect::back();
            }
        }

        foreach ($inputArr as $key => $value) {
            /** @var FrontSetting $frontSetting */
            $frontSetting = FrontSetting::where('key', $key)->first();
            if (! $frontSetting) {
                continue;
            }

            if (in_array($key, ['advertise_image']) && ! empty($value)) {
                $this->fileUpload($frontSetting, $value);

                continue;
            }

            $frontSetting->update(['value' => $value]);
        }
        Flash::success(__('messages.flash.setting_update'));

        return Redirect::back();
    }

    /**
     * @return mixed
     */
    public function fileUpload($frontSetting, $file)
    {
        $frontSetting->clearMediaCollection(FrontSetting::PATH);
        $media = $frontSetting->addMedia($file)->toMediaCollection(FrontSetting::PATH, config('app.media_disc'));
        $frontSetting->update(['value' => $media->getFullUrl()]);

        return $frontSetting;
    }

    /**
     * @return mixed
     */
    public function changeJobFeatured($id)
    {
        FrontSetting::where('key', '=', 'featured_jobs_enable')->update(['value' => $id]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }

    /**
     * @return mixed
     */
    public function changeCompanyFeatured($id)
    {
        FrontSetting::where('key', '=', 'featured_companies_enable')->update(['value' => $id]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }

    /**
     * @return mixed
     */
    public function changeJobCountry($id)
    {
        FrontSetting::where('key', '=', 'latest_jobs_enable')->update(['value' => $id]);

        return $this->sendsuccess(__('messages.flash.status_change'));
    }
}
