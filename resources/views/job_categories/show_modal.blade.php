<div id="showModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_category.show_job_category') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="maritalStatusValidationErrorsBox"></div>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.job_category.name').(':'), ['class' => 'form-label']) }}
                        <p id="showJobCategoryName" class="text-gray-600"></p>
                    </div>
                    <div class="mb-5">
                        {{ Form::label('description', __('messages.job_category.description').(':'),['class' => 'form-label']) }}
                        <p id="showJobCategoryDescription" class="text-gray-600"></p>
                    </div>
            </div>
        </div>
    </div>
</div>
