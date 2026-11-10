<div class="d-flex justify-content-center">
    <a href="javascript:void(0)" title="{{__('messages.common.edit') }}"
       class="btn px-2 text-primary fs-3 {{ checkLanguageSession() == 'ar' ? 'pe-0' : 'ps-0' }} subscription-edit-btn" data-id="{{ $row->id }}" data-bs-toggle="tooltip">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    @if(!$row->is_trial_plan == 1)
        <button type="button" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
                class="subscription-delete-btn btn px-2 text-danger fs-3 {{ checkLanguageSession() == 'ar' ? 'ps-0' : 'pe-0' }} {{ $row->active_subscriptions_count > 0 ? 'disabled' : '' }}"
                data-bs-toggle="tooltip">
            <i class="fa-solid fa-trash"></i>
        </button>
    @endif
</div>


