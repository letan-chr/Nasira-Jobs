<div class="d-flex justify-content-center">
    <a title="{{ __('messages.common.show') }}
            " class="btn px-2 inquiry-show-btn text-primary fs-3 ps-0 action-btn" data-id="{{ $row->id }}" data-bs-toggle="tooltip">
        <i class="fas fa-eye"></i>
    </a>

    <a title="{{ __('messages.common.delete') }}" data-id="{{ $row->id }}"
       class="inquiry-delete-btn btn px-2 text-danger fs-3 ps-0" data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
