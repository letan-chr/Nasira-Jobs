<div class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" id="editCareerLevelModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.career_level.edit_career_level') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'editCareerLevelForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="editValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('careerLevelId',null,['id'=>'careerLevelId']) }}
                <div class="mb-5">
                    {{ Form::label('level_name',__('messages.career_level.level_name').':', ['class' => 'form-label']) }}
                    <span
                            class="required"></span>
                    {{ Form::text('level_name', null, ['class' => 'form-control','required','id' => 'editCareerLevel', 'placeholder' => __('messages.career_level.level_name')]) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'editCareerLevelBtnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" id="btnEditCancel" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
