{{ Form::open(['route' => 'settings.update', 'id' => 'editFrontSettingForm']) }}
    {{ Form::hidden('sectionName', $sectionName) }}
    <div class="row mt-3">
        <div class="col-sm-12 my-0">
            {{ Form::label('address', __('messages.setting.address') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::textarea('address', $setting['address'], ['class' => 'form-control h-75', 'required', 'placeholder' => __('messages.setting.address')]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::label('phone', __('messages.setting.phone') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            <br>
            {{ Form::tel('phone', $setting['phone'], ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'required', 'id' => 'phoneNumber']) }}
            {{ Form::hidden('region_code', null, ['id' => 'prefix_code']) }}
            <br>
            <p id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.phone.valid_number') }}</p>
            <p id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></p>
        </div>
        <div class="col-sm-6">
            {{ Form::label('email', __('messages.setting.email') . ':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::email('email', $setting['email'], ['class' => 'form-control', 'required', 'placeholder' => __('messages.setting.email')]) }}
        </div>
    </div>
    <div class="mt-4 mb-5">
        <!-- Submit Field -->
        <div class="d-flex justify-content-end">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-3']) }}
            <a href="{{ route('settings.index', ['section' => 'front_office_details']) }}"
                class="btn btn-secondary me-2">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
    {{ Form::close() }}
