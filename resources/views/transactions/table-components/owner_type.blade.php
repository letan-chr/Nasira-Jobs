@if($row->owner_type == \App\Models\Subscription::class)
    {{ __('messages.company_subscription') }}
@endif
