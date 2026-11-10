<div id="showModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job.reported_jobs_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                    <div class="mb-5">
                        {{ Form::label('title', __('messages.company.title').':', ['class' => 'form-label']) }}
                        <p class="text-gray-600 showName"></p>
                    </div>
                        <div class="mb-5">
                            {{ Form::label('company_image', __('messages.company.image').':', ['class' => 'form-label']) }}
                            <br>
                            <div class="image image-medium me-3">
                                <img src="" id="documentUrl" class="testimonial-modal-img">
                                <label id="noDocument">{{ __('messages.n/a') }}</label>
                            </div>
                        </div>
                <div class="mb-5">
                    {{ Form::label('reported_by',__('messages.company.reported_by').':', ['class' => 'form-label']) }}
                            <p id="showReportedBy" class="text-gray-600"></p>
                        </div>
                        <div class="mb-5">
                            {{ Form::label('reported_on',__('messages.company.reported_on').':', ['class' => 'form-label']) }}
                            <p id="showReportedOn" class="text-gray-600"></p>
                        </div>
                        <div class="mb-5">
                            {{ Form::label('notes',__('messages.company.notes').':', ['class' => 'form-label']) }}
                            <p id="showNote" class="text-gray-600" style="width:100%; word-wrap: break-word;"></p>
                        </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>




