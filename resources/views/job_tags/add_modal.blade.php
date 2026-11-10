<div id="addJobTagModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_tag.new_job_tag') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addJobTagForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="jobTagValidationErrorsBox"></div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.job_tag.name').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('name', null, ['id'=>'jobTagName','class' => 'form-control','required', 'placeholder' => __('messages.job_tag.name')]) }}
                </div>
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('description', __('messages.job_tag.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div id="addJobTagDescriptionQuillData"></div>
                    {{ Form::hidden('description', null, ['id' => 'job_tag_desc']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'jobTagBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0 quill-btn"
                        id="maritalStatusBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>




