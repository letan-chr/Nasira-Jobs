@if (!$row->hasResumeAvailable)
    <a href="{{url('employer/resume-download', $row->id)}}" class="text-decoration-none" >
     {{__('messages.common.download')}}
    </a>
@else
    {{__('messages.n/a')}}
@endif
