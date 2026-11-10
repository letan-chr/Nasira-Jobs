<div class="modal fade" tabindex="-1" role="dialog" id="showOwnershipModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.ownership_type.ownership_type_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                    <div class="mb-5">
                        {{ Form::label('name',__('messages.common.name').':', ['class' => 'form-label']) }}
                        <br>
                        <p id="showOwnershipName" class="text-gray-600"></p>
                    </div>
                    <div class="mb-5">
                        {{ Form::label('description',__('messages.common.description').':', ['class' => 'form-label']) }}
                        <br>
                        <div class="reported-note">
                            <p id="showOwnershipDescription" class="text-gray-600"></p>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
