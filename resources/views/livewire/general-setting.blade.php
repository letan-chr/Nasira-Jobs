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
        <div class="col-md-5 col-sm-6 mb-5">
            {{ Form::label('status', __('messages.setting.enable_google_recaptcha'), ['class' => 'form-label d-inline']) }}
            <span class="required"></span>
            <div class="form-check form-switch">
                <input class="form-check-input" name="enable_google_recaptcha" type="checkbox" value="1"
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
                {{ Form::select('default_language', $languages, $setting['default_language'] ?? null, ['class' => 'form-select', 'aria-label' => 'Select a language', 'data-control' => 'select2', 'placeholder' => __('messages.common.select_language')]) }}
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-12">
            <div class="form-check form-switch">
                {{ Form::label('job_approved', __('messages.pending_jobs.job_approved'), ['class' => 'form-label']) }}
                <input class="form-check-input" name="job_approved" type="checkbox"
                    {{ isset($setting['job_approved']) ? 'checked' : '' }} value="1">
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
