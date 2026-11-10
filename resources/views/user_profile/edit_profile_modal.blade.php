<div id="editAdminProfileModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.user.edit_profile') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'editAdminProfileForm','files'=>true]) }}
            <div class="modal-body">
                {{--            <div class="alert alert-danger  hide d-none" id="profileErrorMsg"></div>--}}
                {{ Form::hidden('user_id',null,['id'=>'editUserId']) }}
                {{csrf_field()}}
                <div class="row">
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('first_name', __('messages.candidate.first_name').(':'), ['class' => 'form-label required']) }}
                    {{ Form::text('first_name', null, ['id'=>'firstName','class' => 'form-control form-control-solid','required', 'placeholder' => __('messages.candidate.first_name')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('last_name',__('messages.candidate.last_name').(':'),['class' => 'form-label']) }}
                    {{ Form::text('last_name', null, ['id'=>'lastName','class' => 'form-control form-control-solid', 'placeholder' => __('messages.candidate.last_name')]) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('email', __('messages.candidate.email').(':'),['class' => 'required form-label']) }}
                    {{ Form::text('email', null, ['id'=>'userEmail','class' => 'form-control form-control-solid','required', 'placeholder' => __('messages.candidate.email')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5 mobile-itel-width">
                    {{ Form::label('phone',__('messages.candidate.phone').(':'),['class' => 'form-label ']) }}
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::tel('phone', null, ['class' => 'form-control form-control-solid','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
                    </div>
                    {{ Form::hidden('region_code',null,['id'=>'profilePrefixCode']) }}
                    <p id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">{{__('messages.phone.valid_number')}}</p>
                    <p id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">{{__('messages.phone.invalid_number')}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12 mb-5" io-image-input="true">
                    <div class="d-block mb-2">
                        {{__('messages.candidate.profile').':'}}
                        <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
                    </div>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="profilePicturePreview"
                                 style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_profile') }}">
                                <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                    {{ Form::file('image',['id'=>'profilePicture','class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'btnEditSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
        {{ Form::close() }}
    </div>
</div>
</div>
{{--new changeLanguageModal--}}
<div id="changeAdminLanguageModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{  __('messages.user_language.change_language') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'changeAdminLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="editProfileValidationErrorsBox"></div>
                {{csrf_field()}}
                <div class="">
                    {{ Form::label('language',__('messages.user_language.language').(':'), ['class' => 'required form-label']) }}
                    {{ Form::select('language', getUserLanguages(), getLoggedInUser()->language, ['id'=>'adminLanguage','class' => 'form-select form-select-solid','required', 'data-control'=>'select2']) }}
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'btnLanguageChange','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                    <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                            id="btnEditCancel"
                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>






