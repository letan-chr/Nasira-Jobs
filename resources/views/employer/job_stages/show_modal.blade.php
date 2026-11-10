<div id="showJobStageModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.job_stage.job_stage_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger hide d-none" id="maritalStatusValidationErrorsBox"></div>
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('name',__('messages.job_tag.name').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showName" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('description',__('messages.job_tag.description').(':'),['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showDescription" class="fs-5 text-gray-800"></p>
                    </div>

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

