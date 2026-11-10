<div class="d-flex align-items-center">
    <div class="image image-circle image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
        <img src="{{ $row->candidate->candidate_url }}" alt="" class="user-img">
    </div>
    <div class="d-flex flex-column">
        <a href="javascript:void(0)" class="mb-1 show-candidate-modal-btn text-decoration-none"
           data-id="{{ $row->id }}">{{ $row->candidate->user->full_name }}</a>
    </div>
</div>
