<div id="addFAQsModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{  __('messages.faq.new_faq') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addFAQsForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="validationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('title',__('messages.faq.title').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('title', null, ['class' => 'form-control ','required','placeholder' => __('messages.faq.title')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('description',__('messages.faq.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div id="addFaqDescriptionQuillData"></div>
                    {{ Form::hidden('description', null, ['id' => 'faqs_desc']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'addFaqSaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="btnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
