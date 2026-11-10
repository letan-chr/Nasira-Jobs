<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{$row->image_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="javascript:void(0)" class="mb-1 job-category-show-btn text-decoration-none"
           data-id="{{ $row->id }}">{{ Str::limit($row->name, 50) }}</a>
    </div>
</div>
