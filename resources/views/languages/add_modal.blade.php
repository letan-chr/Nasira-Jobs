<div id="addLanguageModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.language.new_language') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addLanguageForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="languageValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('language',__('messages.language.language').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('language', null, ['class' => 'form-control','required','id'=>'languages','placeholder' => __('messages.language.language')] ) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('iso_code',__('messages.language.iso_code').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('iso_code', '', ['class' => 'form-control','required', 'id' => 'languageIsoCode','placeholder' => __('messages.language.iso_code')]) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'languageBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="languageBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
