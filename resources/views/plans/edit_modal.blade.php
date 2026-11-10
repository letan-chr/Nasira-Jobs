<div id="editSubscriptionModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.plan.edit_subscription_plan') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'editSubscriptionForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                {!! Form::hidden('planId',null,['id'=>'planId']) !!}
                <div class=" mb-5">
                    {{ Form::label('name', __('messages.inquiry.name').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('name', null, ['id'=>'editName','class' => 'form-control','required', 'placeholder' => __('messages.inquiry.name')]) }}
                </div>
                <div class=" mb-5">
                    {{ Form::label('allowed_jobs', __('messages.plan.allowed_jobs').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('allowed_jobs', null, ['id'=>'editAllowedJobs','class' => 'form-control allowed-jobs','required', 'min' => '1', 'max' => '99999', 'placeholder' => __('messages.plan.allowed_jobs'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                </div>
                <div class=" mb-5">
                    {{ Form::label('plan_currency', __('messages.plan.currency').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {!! Form::select('salary_currency_id',[], null, ['id'=>'editCurrency','required','class' => 'form-selectselect2Selector','placeholder' => __('messages.company.select_currency')]) !!}
                </div>
                <div class=" mb-5">
                    {{ Form::label('amount', __('messages.plan.amount').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('amount', null, ['id'=>'editAmount','class' => 'form-control amount','required', 'min' => '1', 'max' => '99999','readonly','placeholder' => __('messages.plan.amount')]) }}
                </div>
                {{-- <div class="mb-5">
                    {{ Form::label('status',__('messages.common.status').(':'), ['class' => 'form-label']) }}
                    <br>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input is-active" name="unlimited_plan" type="checkbox"
                               value="1"
                               tabindex="8" id="editUnlimitedPlan" checked>
                    </div>
                </div> --}}
                <div class="mb-5">
                    <input type="checkbox" class="form-check-input" name="unlimited_plan" id="editUnlimitedPlan" value="1" >
                    <label class="form-check-label ms-2" for="formCheck">{{ __('messages.pending_jobs.unlimited_plan') }}</label>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editSubscriptionSaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="planBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
