<div id="editOwnershipTypeModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.ownership_type.edit_ownership_type') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'editOwnerShipForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger  hide d-none" id="editValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {{ Form::hidden('ownerShipTypeId',null,['id'=>'ownerShipTypeId']) }}
                <div class="mb-5">
                    {{ Form::label('name',__('messages.common.name').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('name', null, ['id'=>'editName','class' => 'form-control','required','placeholder'=> __('messages.common.name')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('description', __('messages.marital_status.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{--                        {{ Form::textarea('description', '', ['class' => 'form-control form-control-solid', 'rows' => 5, 'id' => 'editDescription']) }}--}}
                    <div id="editOwnershipDescription"></div>
                    {{ Form::hidden('description', null, ['id' => 'edit_ownership_desc']) }}
                </div>


            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'btnEditSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0" id="btnEditCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
