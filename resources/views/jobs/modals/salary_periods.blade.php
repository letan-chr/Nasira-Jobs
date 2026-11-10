<div id="createSalaryPeriodModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.salary_period.new_salary_period') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'createSalaryPeriodForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="salaryPeriodValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('period',__('messages.salary_period.period').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('period', null, ['id'=>'period','class' => 'form-control','required', 'placeholder' => __('messages.salary_period.period')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('description',__('messages.salary_period.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div id="addSalaryPeriodDescriptionQuillData"></div>
                    {{ Form::hidden('description', null, ['id' => 'salary_period_desc']) }}
                </div>

            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'salaryPeriodBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="salaryPeriodBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
