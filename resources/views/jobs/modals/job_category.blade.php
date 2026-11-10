<div id="createJobCategoryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_category.new_job_category') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'createJobCategoryForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="jobCategoryValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.job_category.name').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('name', null, ['class' => 'form-control','required', 'placeholder' => __('messages.job_category.name')]) }}
                </div>
                <div class="col-sm-12 mb-5 h-100">
                    {{ Form::label('description',__('messages.job_category.description').':', ['class' =>'form-label']) }}
                    <span class="required"></span>
                    {{--                        {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'jobCategoryDescription', 'rows' => '5']) }}--}}
                    <div id="addJobCategoryDescriptionQuillData" class="job-category-description"></div>
                    {{ Form::hidden('description', null, ['id' => 'jobCategoryDescriptionValue']) }}
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-5" io-image-input="true">
                    <label for="category_image" class="form-label">
                        {{__('messages.common.category_image').':'}}
                        <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
                    </label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="logoPreview"
                                 style="background-image: url({{ asset('assets/img/default-user.png') }})">
                            </div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_category_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('customer_image',['id'=>'customerImage','class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'jobCategoryBtnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" id="jobCategoryBtnCancel" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>
