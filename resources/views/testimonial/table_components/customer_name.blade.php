<div class="d-flex align-items-center">
    <a href="javascript:void(0)">
        <div class="image image-mini image-circle {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{$row->customer_image_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="javascript:void(0)" class="mb-1 testimonial-show-btn text-decoration-none"
           data-id="{{$row->id}}">{{$row->customer_name}}</a>
    </div>
</div>
