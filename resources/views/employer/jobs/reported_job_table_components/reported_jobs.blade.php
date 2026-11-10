<div class="d-flex align-items-center">
    <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
        <img src="{{$row->job->company->company_url}}" alt=""
             class="">
    </div>
    <div class="d-flex flex-column">
        <a href="{{route('front.job.details', $row->job->job_id)}}" class="text-decoration-none"
           target="_blank">{{$row->job->job_title}}</a>
    </div>
</div>
