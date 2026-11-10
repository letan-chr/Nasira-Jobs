<?php

        $isJobExpiry = false;
        if (\Carbon\Carbon::now() > $row->job->job_expiry_date) {
            $isJobExpiry = true;
        }

        $isCompleted = false;
        $isShortlisted = false;
        $isJobStage = false;
        $jobStageId = null;
        $isRejected = false;
        $isApplied = false;

        if ($row->status == 1) {
            $isApplied = true;
        }
        if ($row->status == 2) {
            $isRejected = true;
        }
        if ($row->status == 3) {
            $isCompleted = true;
        }
        if ($row->status == 4) {
            $isShortlisted = true;
        }

        if (!empty($row->job_stage_id)) {
            $isJobStage = true;
            $jobStageId = $row->job_stage_id;
        }
?>


<div class="dropdown">
    <a class="btn btn-primary btn-sm dropdown-toggle" id="actionDropDown" data-bs-toggle="dropdown"
       aria-expanded="false">
        {{__('messages.common.action')}}
    </a>
    <ul class="fs-6 py-4 dropdown-menu customDropdown"
        aria-labelledby="dropdownMenuButton1">
        <li>
            <input type="hidden" name="data-job-id" value="{{$this->jobId}}" id="dataJobId">
            @if(!$isCompleted && !$isRejected)
                @if(!$isShortlisted)
                    <a href="javascript:void(0)" class="btn btn-sm dropdown-item job-application-short-list"
                       data-id="{{$row->id}}">{{__('messages.common.shortlist')}}</a>
                @else
                    @if(!$isJobExpiry)
                        <a href="javascript:void(0)" class="btn btn-sm dropdown-item change-job-stage"
                           data-id="{{$row->id}}"
                           data-stage-id="{{$jobStageId}}">{{__('messages.job_stage.job_stage')}}</a>
                    @endif
                @endif

                @if(!$isApplied)
                    <a href="javascript:void(0)" class="btn btn-sm dropdown-item job-application-action-completed"
                       data-id="{{$row->id}}">{{__('messages.common.selected')}}</a>
                @endif
                <a href="javascript:void(0)" class="btn btn-sm dropdown-item job-application-action-decline"
                   data-id="{{$row->id}}">{{__('messages.common.rejected')}}</a>
                @if($isJobStage && !$isRejected && !$isJobExpiry)
                    <a  href="{{route('view.slot.screen', ['jobId'=>$this->jobId, 'jobApplicationId'=>$row->id])}}"
                       class="btn btn-sm dropdown-item">{{__('messages.job_stage.slots')}}</a>
                @endif
            @endif
            <a href="javascript:void(0)" class="btn btn-sm dropdown-item job-application-action-delete"
               data-id="{{$row->id}}">{{__('messages.common.delete')}}</a>
        </li>
    </ul>
</div>
