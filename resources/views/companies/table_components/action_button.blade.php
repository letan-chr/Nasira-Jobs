<div class="d-flex justify-content-center">
    <a href="{{route('company.edit', $row->id)}}" title="{{__('messages.common.edit') }}"
       class="btn px-2 text-primary fs-3 {{ checkLanguageSession() == 'ar' ? 'pe-0' : 'ps-0' }}" data-bs-toggle="tooltip">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <button type="button" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
            class="employer-delete-btn btn px-2 text-danger fs-3 {{ checkLanguageSession() == 'ar' ? 'ps-0' : 'pe-0' }}" id="deleteUser" data-bs-toggle="tooltip">
        <i class="fa-solid fa-trash"></i>
    </button>
</div>

