<div class="d-flex justify-content-center">
    <a href="javascript:void(0)" title="{{__('messages.common.show')}}" class="showReportedJobModal btn px-1 text-info fs-3"
       data-id={{ $row->id }} data-bs-toggle="tooltip">
        <i class="fas fa-eye fs-4"></i>
    </a>
    <button type="button" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
            class="reported-job-delete-btn btn px-2 text-danger fs-3 {{ checkLanguageSession() == 'ar' ? 'ps-0' : 'pe-0' }}" id="deleteUser" data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
