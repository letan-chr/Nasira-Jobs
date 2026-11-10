<div id="reasonshowModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.common.show') }} {{ __('messages.pending_jobs.reason') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-5">
                    {{ Form::label('name', __('messages.job.job_title') . ':', ['class' => 'form-label']) }}
                    <p class="text-gray-600 pending_job_title"></p>
                </div>
                <div class="mb-5">
                    {{ Form::label('description', __('messages.pending_jobs.reason') . ':', ['class' => 'form-label']) }}
                    <p id="showReason" class="text-gray-600"></p>
                </div>

            </div>
        </div>
    </div>
</div>
