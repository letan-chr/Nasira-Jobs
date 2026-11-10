<div class="row">
    <div class="col-md-3 col-sm-12">
        <label class="form-label">{{ __('messages.front_settings.featured_jobs_enable') }}</label>
        <label class="pl-0 col-12 form-check form-switch ">
            <input type="checkbox" name="featured_jobs_enable"
                   class="form-check-input featured-job-active {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}"
                   data-id="{{ ($frontSettings['featured_jobs_enable'] == 1) ? 1 : 0 }}"
                    {{ ($frontSettings['featured_jobs_enable'] == 1) ? 'checked' : '' }} >
            <span class=""></span>
        </label>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-12">
        {{ Form::label('currency', __('messages.front_settings.featured_listing_currency').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('currency', $currencies, (isset($frontSettings['currency']) && $frontSettings['currency'])?$frontSettings['currency']:null ,['id'=>'currency','class' => 'form-select frontSettingCurrency','placeholder' => __('messages.company.select_currency'),'required']) }}
    </div>
    <div class="col-md-3 col-sm-12">
        <label name="featured_jobs_price"
               class="form-label">{{ __('messages.front_settings.featured_jobs_price').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_jobs_price', !empty($frontSettings['featured_jobs_price']) ? $frontSettings['featured_jobs_price'] : 0, ['class' => 'form-control salary', 'required','min' => 0, 'max' => '50000','placeholder' => __('messages.front_settings.featured_jobs_price'),'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-md-3 col-sm-12">
        <label name="featured_jobs_days"
               class="form-label">{{ __('messages.front_settings.featured_jobs_due_days').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_jobs_days', $frontSettings['featured_jobs_days'], ['class' => 'form-control salary', 'required','min' => 0, 'max' => '20', 'placeholder' => __('messages.front_settings.featured_jobs_due_days'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>

    <div class="col-xl-3 col-md-3 col-sm-12 mt-5 mb-5">
        <label class="form-label ">{{ __('messages.front_settings.featured_companies_enable') }}</label>
        <label class=" pl-0 col-12 form-check form-switch">
            <input type="checkbox" name="featured_companies_enable"
                   class="form-check-input featured-company-active {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}"
                    {{ ($frontSettings['featured_companies_enable'] == 1) ? 'checked' : '' }}>
            <span class=""></span>
        </label>
    </div>
    <div class="col-md-3 col-sm-12 mt-5 mb-5">
        <label name="featured_jobs_quota"
               class="form-label">{{ __('messages.front_settings.featured_jobs_quota').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_jobs_quota', $frontSettings['featured_jobs_quota'], ['class' => 'form-control salary', 'required','min' => 0, 'max' => '20', 'placeholder' => __('messages.front_settings.featured_jobs_quota'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-md-3 col-sm-12 mt-5 mb-5">
        <label name="featured_companies_price"
               class="form-label">{{ __('messages.front_settings.featured_companies_price').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_companies_price', $frontSettings['featured_companies_price'], ['class' => 'form-control salary', 'required','min' => 0, 'max' => '50000', 'placeholder' => __('messages.front_settings.featured_companies_price'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-md-3 col-sm-12 mt-5 mb-5">
        <label name="featured_companies_days"
               class="form-label">{{ __('messages.front_settings.featured_companies_due_days').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_companies_days', $frontSettings['featured_companies_days'], ['class' => 'form-control salary', 'required','min' => 0, 'max' => '20', 'placeholder' =>__('messages.front_settings.featured_companies_due_days'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")' ]) }}
    </div>

    <div class="col-xl-3 col-md-3 col-sm-12">
        <label class="form-label">{{ __('messages.front_settings.latest_jobs_enable') }}
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{ __('messages.front_settings.latest_jobs_enable_message') }}">
                    <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                </span>
        <label class="pl-0 col-12 form-check form-switch ">
            <input type="checkbox" name="latest_jobs_enable"
                   class=" form-check-input job-country-active {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}"
                    {{ (isset($frontSettings['latest_jobs_enable']) && $frontSettings['latest_jobs_enable'] == 1) ? 'checked' : '' }}>
            <span class="custom-switch-indicator"></span>
        </label>
    </div>
    <div class="col-md-3 col-sm-12">
        <label name="featured_companies_quota"
               class="form-label">{{ __('messages.front_settings.featured_companies_quota').':' }}</label>
        <span class="required"></span>
        {{ Form::text('featured_companies_quota', $frontSettings['featured_companies_quota'], ['class' => 'form-control salary', 'required','min' => 0, 'max' => '20', 'placeholder' => __('messages.front_settings.featured_companies_quota'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="d-block" io-image-input="true">
            <label for="favicon" class="form-label">
                {{__('web.job_menu.advertise_image').':'}}
                <span class="text-danger">*</span>
                <span data-bs-toggle="tooltip"
                      data-placement="top"
                      data-bs-original-title="{{  __('messages.setting.image_validation') }}">
                    <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                </span>
            </label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="previewImage"
                         style="background-image: url({{ !empty($frontSettings['advertise_image']) ? $frontSettings['advertise_image'] : asset('assets/img/infyom-logo.png') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('advertise_image',['id'=>'advertiseImage','class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','name' => 'save', 'id' => 'saveJob']) }}
        <a href="{{ route('front.settings.index') }}"
           class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>
