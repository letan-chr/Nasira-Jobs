<div class="d-flex justify-content-center">
    <button type="button" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
            class="subscriber-delete-btn btn px-2 text-danger fs-3 pe-0 {{ $row->active_subscriptions_count > 0 ? 'disabled' : '' }}"
            data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
