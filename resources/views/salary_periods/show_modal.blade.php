<div id="showSalaryPeriodModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">{{ __('messages.salary_period.salary_period_detail') }}</h3>
            <button type="button" aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal">
            </button>
        </div>
        {{ Form::open(['id' => 'showForm']) }}
        <div class="modal-body">
            <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" id="salaryPeriodValidationErrorsBox">
                <i class="fa-solid fa-face-frown me-5"></i>
            </div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.salary_period.period').(':'), ['class' => 'form-label']) }}
                    <p id="showSalaryPeriod" class="text-gray-600"></p>
                </div>
                <div class="mb-5">
                    {{ Form::label('description',__('messages.salary_period.description').(':'),['class' => 'form-label']) }}
                    <p id="showSalaryPeriodDescription" class="text-gray-600"></p>
                </div>

            </div>
        {{ Form::close() }}
    </div>
</div>
</div>
