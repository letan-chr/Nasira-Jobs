<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }} ">
            <img src="{{$row->blog_image_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="{{route('posts.show', $row->id)}}" class="mb-1 show-btn text-decoration-none" data-id="{{$row->id}}">
            {{ Str::limit($row->title,25) }}
        </a>
    </div>
</div>
