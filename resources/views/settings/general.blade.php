@extends('settings.index')
@section('title')
    {{ __('messages.setting.general') }}
@endsection
@section('section')
    {{ Form::open(['route' => 'settings.update', 'files' => true, 'id' => 'editGeneralSettingForm']) }}
    {{ Form::hidden('sectionName', $sectionName) }}
    <div class="row mt-3">
        <div class="col-sm-6">
            {{ Form::label('application_name', __('messages.setting.application_name') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('application_name', $setting['application_name'], ['class' => 'form-control', 'required', 'placeholder' => __('messages.setting.application_name')]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::label('application_name', __('messages.setting.company_url') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('company_url', $setting['company_url'], ['class' => 'form-control', 'required', 'id' => 'companyUrl', 'placeholder' => __('messages.setting.company_url')]) }}
        </div>
        <div class="col-sm-12 my-0 mt-5">
            {{ Form::label('company_description', __('messages.setting.company_description') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::textarea('company_description', $setting['company_description'], ['class' => 'form-control h-75', 'required', 'placeholder' => __('messages.setting.company_description')]) }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-5">
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-5" io-image-input="true">
                    <label for="app_logo" class="form-label">
                        {{ __('messages.setting.logo') . ':' }}
                        <span class="required"></span>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                            <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                        </span>
                    </label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="logoPreview"
                                style="background-image: url({{ !empty($setting['logo']) ? $setting['logo'] : asset('assets/img/infyom-logo.png') }})">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_app_logo') }}">
                                <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                    {{ Form::file('logo', ['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-5" io-image-input="true">
                    <label for="app_footer_logo" class="form-label">
                        {{ __('messages.app_footer_logo') . ':' }}
                        <span class="required"></span>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                            <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                        </span>
                    </label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="footerLogoPreview"
                                style="background-image: url({{ !empty($setting['footer_logo']) ? $setting['footer_logo'] : asset('assets/img/infyom-logo.png') }})">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_app_logo') }}">
                                <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                    {{ Form::file('footer_logo', ['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-5" io-image-input="true">
                    <label for="favicon" class="form-label">
                        {{ __('messages.setting.favicon') . ':' }}
                        <span class="required"></span>
                        <span data-bs-toggle="tooltip" data-placement="top"
                            data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                            <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                        </span>
                    </label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="faviconPreview"
                                style="background-image: url({{ !empty($setting['favicon']) ? $setting['favicon'] : asset('assets/img/infyom-logo.png') }})">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_favicon') }}">
                                <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                    {{ Form::file('favicon', ['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--        <div class="form-group col-sm-4"> --}}
        {{--            <div class="row"> --}}
        {{--                <div class="px-3"> --}}
        {{--                    {{ Form::label('app_footer_logo','Footer Logo:') }}<span class="text-danger">*</span> --}}
        {{--                    <i class="fas fa-question-circle ml-1 mt-1 general-question-mark" data-toggle="tooltip" --}}
        {{--                       data-placement="top" title="Upload 90 x 60 logo to get best user experience."></i> --}}
        {{--                    <label class="image__file-upload"> {{ __('messages.setting.choose') }} --}}
        {{--                        {{ Form::file('footer_logo',['id'=>'footerLogo','class' => 'd-none']) }} --}}
        {{--                    </label> --}}
        {{--                </div> --}}
        {{--                <div class="w-auto pl-3 mt-1"> --}}
        {{--                    <img id='footerLogoPreview' class="img-thumbnail thumbnail-preview" --}}
        {{--                         src="{{($setting['footer_logo']) ? asset($setting['footer_logo']) : asset('assets/img/infyom-logo.png')}}"> --}}
        {{--                </div> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        {{--        <div class="form-group col-sm-4"> --}}
        {{--            <div class="row"> --}}
        {{--                <div class="px-3"> --}}
        {{--                    {{ Form::label('favicon', __('messages.setting.favicon').':') }} --}}
        {{--                    <span class="text-danger">*</span><i class="fas fa-question-circle ml-1 mt-1 general-question-mark" --}}
        {{--                                                         data-toggle="tooltip" data-placement="top" --}}
        {{--                                                         title="The image must be of pixel 16 x 16 and 32 x 32."></i> --}}
        {{--                    <label class="image__file-upload"> {{ __('messages.setting.choose') }} --}}
        {{--                        {{ Form::file('favicon',['id'=>'favicon','class' => 'd-none']) }} --}}
        {{--                    </label> --}}
        {{--                </div> --}}
        {{--                <div class="w-auto pl-3 mt-1"> --}}
        {{--                    <img id='faviconPreview' class="img-thumbnail thumbnail-preview mt-4 width-40px" --}}
        {{--                         src="{{($setting['favicon']) ? asset($setting['favicon']) : asset('assets/img/infyom-logo.png')}}"> --}}
        {{--                </div> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        {{--        <div class="form-group col-lg-12 col-md-12 d-flex justify-content-start"> --}}
        {{--            <label class="custom-switch switch-label row mt-0 pl-0"> --}}
        {{--                <input type="checkbox" name="enable_google_recaptcha" class="custom-switch-input form-check-input" --}}
        {{--                       {{ ($setting['enable_google_recaptcha']) ? 'checked' : '' }} value="1"> --}}
        {{--                <span class="custom-switch-indicator switch-span"></span> --}}
        {{--            </label> --}}
        {{--            <span class="custom-switch-description font-weight-bold fs-6 fw-bolder text-gray-700 mb-3">{{ __('messages.setting.enable_google_recaptcha') }}</span> --}}
        {{--        </div> --}}
        <div class="col-md-5 col-sm-6 mb-5">
            {{ Form::label('status', __('messages.setting.enable_google_recaptcha'), ['class' => 'form-label d-inline']) }}
            <span class="required"></span>
            <div class="form-check form-switch">
                <input class="form-check-input {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}" name="enable_google_recaptcha" type="checkbox" value="1"
                    {{ $setting['enable_google_recaptcha'] ? 'checked' : '' }}
                    placeholder="{{ __('messages.setting.enable_google_recaptcha') }}">
            </div>
        </div>
        <div class="col-md-4 col-lg-3 col-sm-3 col-12">
            <div class="form-group mb-3">
                {{ Form::label('default_country_code', __('messages.common.default_country_code') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('default_country_data', null, ['class' => 'form-control', 'placeholder' => __('messages.common.default_country_code'), 'id' => 'defaultCountryData']) }}
                {{ Form::hidden('default_country_code', $setting['default_country_code'], ['id' => 'defaultCountryCode']) }}
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-12">
            <div class="form-group mb-3">
                {{ Form::label('default_language', __('messages.common.default_language') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('default_language', $languages, $setting['default_language'] ?? null, ['class' => 'form-select', 'aria-label' => 'Select a language', 'data-control' => 'select2', 'placeholder' => __('messages.common.select_language')]) }}
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-12">
            <div class="form-check form-switch">
                {{ Form::label('job_approved', __('messages.pending_jobs.job_approved'), ['class' => 'form-label me-3']) }}
                <input class="form-check-input {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}" name="job_approved"
                    type="checkbox"{{ isset($setting['job_approved']) ? ($setting['job_approved'] ? 'checked' : '') : '' }}
                    value="1">
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        <!-- Submit Field -->
        <div class="d-flex justify-content-end">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-3']) }}
            <a href="{{ route('settings.index', ['section' => 'general']) }}"
                class="btn btn-secondary me-2">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
    {{ Form::close() }}
@endsection
