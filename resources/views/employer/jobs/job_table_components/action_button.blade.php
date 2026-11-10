<div class="d-flex justify-content-center">
    <?php
    $isJobClosed = false;
    $isJobPause = false;
    $isJobDraft = false;

    if ($row->status == 2) {
        $isJobClosed = true;
    }
    if ($row->status == 3) {
        $isJobPause = true;
    }
    if ($row->status == 0) {
        $isJobDraft = true;
    }
    ?>
    @if(!$isJobClosed)
        @if(!$isJobPause && !$isJobDraft)
            <a  href="{{route('job-applications', $row->id)}}" title="{{__('messages.job_applications') }}"
               class="btn px-2 text-info fs-3 pe-0" data-bs-toggle="tooltip"
               data-placement="bottom">
        <span class="svg-icon svg-icon-3">
            <i class="fa fa-users"></i>
        </span>
            </a>
            @endif
        <a href="{{route('job.edit', $row->id)}}" title="{{__('messages.common.edit')}}"
           class=" btn px-2 text-primary fs-3 pe-0 edit-btn" data-bs-toggle="tooltip"
           data-placement="bottom">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        @endif

        <a title="{{(__('messages.tooltip.copy_preview_link'))}}"
           class="btn px-2 text-success fs-3 pe-0 action-btn copy-btn"
           data-job-id="{{$row->job_id}}" data-bs-toggle="tooltip" data-placement="bottom">
        <span class="svg-icon svg-icon-3">
          <i class="fa fa-copy"></i>
        </span>
    </a>
        <a title="{{__('messages.common.delete')}} " data-id="{{ $row->id }}"
           class="employer-job-delete-btn  btn px-2 text-danger fs-3 pe-0" data-bs-toggle="tooltip">
            <i class="fa-solid fa-trash"></i>
        </a>
</div>
