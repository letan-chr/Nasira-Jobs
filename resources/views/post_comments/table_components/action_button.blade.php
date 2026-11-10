<div class="d-flex justify-content-center">
    <a class="btn px-2 text-primary fs-3 py-2 post-comment-show-btn" data-id="{{ $row->id }}" data-bs-toggle="tooltip"
       title="{{__('messages.common.show')}}" >
        <i class="fa-solid fa-eye fs-4"></i>
    </a>
    <a title="<?php echo __('messages.common.delete') ?>" data-id="{{ $row->id }}"
       class="post-comment-delete-btn btn px-2 text-danger fs-3 py-2" data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash fs-4"></i>
    </a>
</div>
