<div class="d-flex align-items-center">
    <a>
        <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{ $row->avatar }}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a
           class="mb-1 text-decoration-none fs-6">
            {{ $row->full_name }}
        </a>
        <span class="fs-6">{{ $row->email }}</span>
    </div>
</div>
