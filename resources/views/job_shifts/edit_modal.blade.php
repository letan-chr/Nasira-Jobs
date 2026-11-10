<div id="jobShiftEditModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ __('messages.job_shift.edit_job_shift') }}</h3>
            <button type="button" aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal">
            </button>
        </div>
        {{ Form::open(['id'=>'editJobShiftForm']) }}
        <div class="modal-body">
            <div class="alert alert-danger  hide d-none" id="editValidationErrorsBox"></div>
            {{ Form::hidden('jobShiftId',null,['id'=>'jobShiftId']) }}
            <div class="mb-5">
                {{ Form::label('shift',__('messages.job_shift.shift').(':'), ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('shift', null, ['id'=>'editShift','class' => 'form-control','required', 'placeholder' => __('messages.job_shift.shift')]) }}
            </div>
            <div class="mb-5">
                {{ Form::label('description',__('messages.job_shift.description').(':'),['class' => 'form-label']) }}
                <span class="required"></span>
                <div id="editJobShiftDescriptionQuillData"></div>
                {{ Form::hidden('description', null, ['id' => 'edit_job_shift_desc']) }}
            </div>

        </div>
        <div class="modal-footer pt-0">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'jobShiftEditSaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
            <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                    id="btnEditCancel"
                    data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
        {{ Form::close() }}
    </div>
</div>
</div>

