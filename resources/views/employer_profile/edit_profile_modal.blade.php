<div id="editEmployerProfileModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.user.edit_profile') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'editEmployerProfileForm','files'=>true]) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBoxCandidate">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('user_id',null,['id'=>'editUserId']) }}
                {{ Form::hidden('company_id',null,['id'=>'companyId']) }}
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('first_name', __('messages.candidate.first_name').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('first_name', null, ['id'=>'firstName','class' => 'form-control','required', 'placeholder' => __('messages.candidate.first_name')]) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('email', __('messages.candidate.email').(':'),['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('email', null, ['id'=>'editEmail','class' => 'form-control','required', 'placeholder' => __('messages.candidate.email')]) }}
                    </div>

                    <div class="col-sm-6 mb-5" io-image-input="true">
                        <label for="profilePicture" class="form-label">
                            {{__('messages.candidate.profile').':'}}
                            <span class="required"></span>
                            <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
                        </label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="profilePicturePreview"
                                     style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                      data-bs-toggle="tooltip"
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

<div id="changeEmployerLanguageModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.user_language.change_language') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'changeEmployerLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="editProfileValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-12">
                        {{ Form::label('language',__('messages.user_language.language').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('language', getUserLanguages(), getLoggedInUser()->language, ['id'=>'employerLanguage','class' => 'form-select','required']) }}
                    </div>
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
