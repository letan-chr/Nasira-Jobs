<div id="reasonModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.common.add') }} {{ __('messages.pending_jobs.reason') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addReasonForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="jobTypeValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.job.job_title') . ':', ['class' => 'form-label']) }}
                    <p class="text-gray-600 pending_job_title"></p>
                </div>
                <div class="mb-5">
                    <input type="hidden" name="id" id="pending_job_id">
                    <input type="hidden" name="status" id="pending_job_status" value="{{ \App\Models\Job::STATUS_SUSPENDED }}">
                    {{ Form::label('name',__('messages.pending_jobs.reason').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    <textarea class="form-control" rows="3" columns="3" id="reject_reason" name="reject_reason" ></textarea>
                </div>
            </div>
            <div class="modal-footer pt-0 ">
                {{ Form::button(__('messages.pending_jobs.reject'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'jobTypeBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0 "
                        id="rejectBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

