<div class="d-flex align-items-center">
    <a>
        <div class="image image-mini image-circle {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{$row->branding_slider_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        {{$row->title}}
    </div>
</div>
