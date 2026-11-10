<div id="showInquiryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.inquiry.inquiry_details') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'inquiryShowForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="inquiryShowValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('name', __('messages.inquiry.name').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <br>
                        <p id="showInquiresName" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('email', __('messages.inquiry.email').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showInquiresEmail" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('phone_no', __('messages.inquiry.phone_no').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showInquiresPhoneNo" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('subject', __('messages.inquiry.subject').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showInquiresSubject" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('created_at', __('messages.common.created_on').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showInquiresCreatedAt" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('updated_at', __('messages.common.last_updated').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showUpdatedAt" class="fs-5 text-gray-800"></p>
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('message',__('messages.inquiry.message').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <p id="showInquiresMessage" class="fs-5 text-gray-800"></p>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

