<div id="createCandidateMaritalStatusModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.marital_status.new_marital_status') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'createCandidateMaritalStatusForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="maritalStatusValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('marital_status', __('messages.marital_status.marital_status').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('marital_status', null, ['id'=>'marital_status','class' => 'form-control','required', 'placeholder' => __('messages.marital_status.marital_status')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('description', __('messages.marital_status.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div id="addMartialDescriptionQuillData"></div>
                    {{ Form::hidden('description', null, ['id' => 'marital_desc']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'maritalStatusBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="maritalStatusBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
