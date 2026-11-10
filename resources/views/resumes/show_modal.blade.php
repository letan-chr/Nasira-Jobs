<div id="showModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.candidate.reported_candidate_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="maritalStatusValidationErrorsBox"></div>
                <div class="row">
                    <div class="col-sm-6">
                        {{ Form::label('image', __('messages.post.image').':', ['class' => 'form-label']) }}
                        <p id="showImage"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('candidate_name', __('messages.job_application.candidate_name').':', ['class' => 'form-label']) }}
                        <p id="showReportedCandidate"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('reported_by', __('messages.company.reported_by').':',['class' => 'form-label']) }}
                        <p id="showReportedBy"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('reported_on', __('messages.company.reported_on').':',['class' => 'form-label']) }}
                        <br>
                        {{ date('jS M, Y', `<p id="showReportedWhen"></p>` ) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('notes', __('messages.company.notes').':',['class' => 'form-label']) }}
                        <p id="showReportedNote"></p>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
