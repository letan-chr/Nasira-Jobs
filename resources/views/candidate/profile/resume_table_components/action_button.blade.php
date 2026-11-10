<div class="d-flex justify-content-center">
    <a href="{{route('download.resume', $row->id)}}"  class="download-link btn px-2 text-primary fs-3 {{ checkLanguageSession() == 'ar' ? 'pe-0' : 'ps-0' }}"><i class="fas fa-download download-margin"></i></a>
    <button type="button" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
            class="delete-resume btn px-2 text-danger fs-3 pe-0" data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>
