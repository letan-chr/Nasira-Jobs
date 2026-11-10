<div id="showNoticeboardModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.noticeboard.noticeboard_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="maritalStatusValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.noticeboard.title').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                    <br>
                    <span id="showNoticeboardTitle" class="fs-5 text-gray-800"></span>
                </div>
                <div class="mb-5">
                    {{ Form::label('is_active', __('messages.common.status').(':'),['class' => 'pb-2 fs-5 text-gray-600']) }}
                    <p id="showIsActive" class="fs-5 text-gray-800"></p>

                </div>
                <div class="mb-5">
                    {{ Form::label('description', __('messages.noticeboard.description').(':'),['class' => 'pb-2 fs-5 text-gray-600']) }}
                    <p id="showNoticeboardDescription" class="fs-5 text-gray-800"></p>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
