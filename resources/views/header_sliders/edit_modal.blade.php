<div id="editHeaderSlidersModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.header_slider.edit_header_slider') }}</h3>
                <button type="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'editHeaderSliderForm', 'files' => true]) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="maritalStatusValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('headerSliderId', null, ['id' => 'headerSliderId']) }}
                <div class="row">
                    <div class="col-sm-12 mb-5" io-image-input="true">
                        <label for="header_slider" class="form-label">
                            {{ __('messages.image_slider.image') . ':' }}
                            <span class="text-danger">*</span>
                            <span data-bs-toggle="tooltip" data-placement="top"
                                data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                                <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                            </span>
                        </label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="editPreviewImage"
                                    style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                    data-placement="top"
                                    data-bs-original-title="{{ __('messages.tooltip.change_image') }}">
                                    <label>
                                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                        {{ Form::file('image_slider', ['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 mb-5">
                        {{ Form::label('status', __('messages.common.status') . ':', ['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}"
                                name="is_active" type="checkbox" value="1" id="editIsActive" checked>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary m-0', 'id' => 'headerSliderEditBtn', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> " . __('messages.common.process')]) }}
                <button type="button"
                    class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                    id="btnCancel" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
