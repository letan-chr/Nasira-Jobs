<div class="d-flex align-items-center">
    <a href="{{ route('candidates.show', $row->id) }}">
        <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
            <img src="{{ $row->candidate_url }}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="{{ route('candidates.show', $row->id) }}"
           class="mb-1 text-decoration-none fs-6">
            {{ $row->user->full_name }}
        </a>
        <span class="fs-6">{{ $row->user->email }}</span>
    </div>
</div>
