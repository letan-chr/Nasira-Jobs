<div id="showModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_type.job_type_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="jobTypeValidationErrorsBox"></div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.job_type.name').(':'), ['class' => 'form-label']) }}
                        <p id="showName" class="text-gray-600"></p>
                    </div>
                    <div class="mb-5">
                        {{ Form::label('description',__('messages.job_type.description').(':'),['class' => 'form-label']) }}
                        <p id="showDescription" class="text-gray-600"></p>
                    </div>

                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>




