<div id="editCurrencyModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('messages.salary_currency.edit_salary_currency') }}</h2>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ Form::open(['id' => 'editCurrencyForm']) }}
            <div class="modal-body scroll-y">
                <div class="alert alert-danger d-none hide" id="editValidationErrorsBox"></div>
                {{ Form::hidden('currencyId', null, ['id' => 'currencyId']) }}
                <div class="row">
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('currency_name', __('messages.salary_currency.currency_name') . ':', ['class' => 'form-label required mb-3']) }}
                        {{ Form::text('currency_name', null, ['id' => 'editCurrencyName', 'class' => 'form-control ', 'required', 'placeholder' => __('messages.salary_currency.currency_name')]) }}
                    </div>
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('currency_icon', __('messages.salary_currency.currency_icon') . ':', ['class' => 'form-label required mb-3']) }}
                        {{ Form::text('currency_icon', null, ['id' => 'editCurrencyIcon', 'class' => 'form-control ', 'required', 'placeholder' => __('messages.salary_currency.currency_icon')]) }}
                    </div>
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('currency_code', __('messages.salary_currency.currency_code') . ':', [
                            'class' => 'required fw-bold fs-6 mb-2',
                        ]) }}
                        {{ Form::text('currency_code', null, ['class' => 'form-control  mb-3 mb-lg-0 currency-code text-uppercase', 'placeholder' => __('messages.salary_currency.currency_code'), 'required', 'id' => 'editCurrencyCode']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary me-2', 'id' => 'btnEditSave', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span>" . __('messages.common.process')]) }}
                <button type="button"
                    class="btn btn-secondary btn-active-light-primary me-2 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }}"
                    data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
