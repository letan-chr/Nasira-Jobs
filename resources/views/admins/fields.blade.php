<div class="row">
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('first_name',__('messages.candidate.first_name').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::text('first_name', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.first_name')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('last_name',__('messages.candidate.last_name').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('last_name', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.last_name')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('email',__('messages.candidate.email').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('email', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.email')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-55 mobile-itel-width">
        {{ Form::label('phone', __('messages.candidate.phone').':', ['class' => 'form-label ']) }}
        <br>
        {{ Form::tel('phone', null, ['class' => 'form-control d', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber','placeholder' => __('messages.inquiry.phone_no')])}}
        {{ Form::hidden('region_code',null,['id'=>'prefix_code']) }}
        <p id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">{{__('messages.phone.valid_number')}}</p>
        <p id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">{{__('messages.phone.invalid_number')}}</p>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('password',__('messages.candidate.password').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <input class="form-control  form-control-solid" id="password" type="password"
               name="password" required placeholder="{{__('messages.candidate.password')}}">
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('cpassword',__('messages.candidate.conform_password').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <input class="form-control  form-control-solid" id="cpassword" type="password"
               name="cpassword" required placeholder="{{__('messages.candidate.conform_password')}}">
    </div>
    @if (! empty($roles))
        <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
            {{ Form::label('role', __('messages.role.name').':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::select('role', $roles, old('role', 'Admin'), ['class' => 'form-select', 'required', 'id' => 'adminRole']) }}
        </div>
    @endif
    {{ Form::label('Profile',__('messages.profile').':', ['class' => 'form-label']) }}
    <div class="d-block">
        <div class="image-picker">
            <div class="image previewImage" id="logoPreview"
                 style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
            </div>
            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                  data-placement="top" data-bs-original-title="{{__("messages.tooltip.change_profile")}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('profile',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-5">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('admin.index') }}"
           class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>

