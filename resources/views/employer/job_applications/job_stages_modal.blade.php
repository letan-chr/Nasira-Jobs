<div id="changeJobStageModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.job_stage.job_stage_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'changeJobStageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger hide d-none" id="maritalStatusValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('job_stage', __('messages.job_stage.job_stage').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('job_stage', [], null, ['class' => 'form-select','required', 'id' => 'jobStageId','data-control'=>'select2', 'placeholder' => __('messages.common.select_job_stage')]) }}
                    </div>
                    <input type="hidden" name="job_application_id" value="" id="jobApplicationId">
                </div>

            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'changeJobStageBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="jobStageBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
