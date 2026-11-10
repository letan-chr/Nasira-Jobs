<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{$row->company->company_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="javascript:void(0)" class="mb-1 text-decoration-none fs-6 show-employer-detail-btn" data-id="{{$row->id}}">
            {{$row->company->user->full_name}}
        </a>
    </div>
</div>
