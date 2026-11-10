<div class="modal fade" tabindex="-1" role="dialog" id="editTestimonialModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__('messages.testimonial.edit_testimonial')}}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'editTestimonialForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('testimonialId',null,['id'=>'testimonialId']) }}
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('customer_name', __('messages.testimonial.customer_name').':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('customer_name', null, ['class' => 'form-control form-control-solid','required' , 'id' => 'editCustomerName', 'placeholder' => __('messages.testimonial.customer_name')]) }}
                    </div>

                    <div class="col-sm-12 mb-5" io-image-input="true">
                        <label for="customer_image" class="form-label">
                            {{__('messages.testimonial.customer_image').':'}}
                            <span class="required"></span>
                            <span data-bs-toggle="tooltip"
                                  data-placement="top"
                                  data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
                        </label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="editPreviewImage"
                                     style="background-image: url({{ asset('assets/img/infyom-logo.png') }})">
                                </div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('customer_image',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-5">
                        {{ Form::label('description', __('messages.testimonial.description').':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        <div id="editTestimonialDescriptionQuillData"></div>
                        {{ Form::hidden('description', null, ['id' => 'testimonial_edit_desc']) }}
                    </div>
                </div>

            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'testimonialEditBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0" id="btnEditCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
