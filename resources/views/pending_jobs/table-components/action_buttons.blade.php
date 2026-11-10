<div class="d-flex justify-content-center">
    <button type="button" title="{{__('messages.pending_jobs.accepted') }}" data-id="{{ $row->id }}" data-status="{{ \App\Models\Job::STATUS_OPEN }}"
        class="live-btn btn px-2 text-primary fs-3 pe-0" data-bs-toggle="tooltip">
        <i class="fa-solid fa-check border p-2 border-2 border-primary rounded-circle fs-6 fw-bold"></i>
    </button>
    <button type="button" title="{{__('messages.pending_jobs.reject') }}" data-id="{{ $row->id }}" data-status="{{ \App\Models\Job::STATUS_SUSPENDED }}"
        class="suspend-btn btn px-2 text-danger fs-3 pe-0" data-bs-toggle="tooltip">
        <i class="fa-solid fa-xmark border p-2 px-3 border-2 border-danger rounded-circle fs-6 fw-bold"></i>
    </button>
</div>
