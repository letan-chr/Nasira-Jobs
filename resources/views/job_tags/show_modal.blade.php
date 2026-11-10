<div id="showJobTagModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_tag.job_tag_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger hide d-none" id="jobTagValidationErrorsBox"></div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.job_tag.name').(':'), ['class' => 'form-label']) }}
                        <p id="showJobTagName" class="fs-6 text-gray-800"></p>
                    </div>
                    <div class="mb-5">
                        {{ Form::label('description',__('messages.job_tag.description').(':'),['class' => 'form-label']) }}
                        <p id="showJobTagDescription" class="fs-6 text-gray-800"></p>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

