<div id="createCompanyModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.company.new_company') ?? 'Add Company' }}</h3>
                <button type="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{ Form::open(['id' => 'createCompanyQuickForm']) }}
            <div class="modal-body">
                <p class="text-muted mb-4">Company name is enough. Other details are optional.</p>
                <div class="mb-5">
                    {{ Form::label('name', __('messages.company.employer_name').':', ['class' => 'form-label required']) }}
                    {{ Form::text('name', null, ['id' => 'quickCompanyName', 'class' => 'form-control', 'required', 'placeholder' => __('messages.company.employer_name')]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('email', __('messages.company.email').':', ['class' => 'form-label']) }}
                    {{ Form::email('email', null, ['id' => 'quickCompanyEmail', 'class' => 'form-control', 'placeholder' => __('messages.company.email').' (optional)']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary m-0', 'id' => 'companyQuickBtnSave', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 ms-5 me-0" data-bs-dismiss="modal">
                    {{ __('messages.common.cancel') }}
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
