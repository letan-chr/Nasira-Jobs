<div id="addImageSlidersModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.image_slider.new_image_slider') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addImageSliderForm','files'=>true]) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="row">


                    <div class="col-sm-12 mb-5" io-image-input="true">
                        <label for="image_slider" class="form-label">
                            {{__('messages.image_slider.image').':'}}
                            <span class="text-danger">*</span>
                            <span data-bs-toggle="tooltip"
                                  data-placement="top"
                                  data-bs-original-title="{{  __('messages.image_slider.image_title_text') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
                        </label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="previewImage"
                                     style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('image_slider',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        {{--                        {{ Form::label('description', __('messages.image_slider.description').':') }}--}}
                        {{--                        {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) }}--}}
                        {{ Form::label('description', __('messages.image_slider.description').':',['class' => 'form-label']) }}
                        <div id="addImageSliderDescriptionQuillData"></div>
                        {{ Form::hidden('description', null, ['id' => 'descriptionData']) }}
                    </div>
                    <div class="col-sm-4 mb-0 pt-1 mt-5">
                        {{--                        <label>{{ __('messages.common.status').':' }}</label><br>--}}
                        {{--                        <label class="custom-switch pl-0">--}}
                        {{--                            <input type="checkbox" name="is_active" class="custom-switch-input"--}}
                        {{--                                   value="1" id="active" checked>--}}
                        {{--                            <span class="custom-switch-indicator"></span>--}}
                        {{--                        </label>--}}
                        {{ Form::label('status', __('messages.common.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}" name="is_active" type="checkbox"
                                   value="1" checked>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'imageSliderSaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0" id="btnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
