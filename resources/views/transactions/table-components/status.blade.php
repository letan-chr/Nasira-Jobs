@if($row->status == \App\Models\Transaction::DIGITAL)
    <span class="badge bg-light-success">{{__('messages.filter_name.digital')}}</span>
@elseif($row->status == \App\Models\Transaction::STRIPE_PAYMENT)
    <span class="badge bg-light-success">{{ __('messages.filter_name.stripe') }}</span>
@elseif($row->status == \App\Models\Transaction::PAYPAL_PAYMENT)
    <span class="badge bg-light-success">{{ __('messages.filter_name.paypal') }}</span>
@elseif($row->status == \App\Models\Transaction::PAYSTACK_PAYMENT)
    <span class="badge bg-light-success">{{ __('messages.filter_name.paystack') }}</span>
@elseif($row->status == \App\Models\Transaction::MANUALLY)
    <span class="badge bg-light-success">{{__('messages.filter_name.manually')}}</span>
@else

@endif
