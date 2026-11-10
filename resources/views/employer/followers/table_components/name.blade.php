<div class="d-flex align-items-center">
    <a href="#" class="image image-mini image-circle {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{$row->user->avatar}}" alt="" class="user-img">
    </a>
    <div class="d-flex flex-column">
        <a href="{{route('front.candidate.details', $row->user->candidate->unique_id)}}" target="_blank"
           class="mb-1 show-btn text-decoration-none">{{$row->user->full_name}}</a>
    </div>
</div>
