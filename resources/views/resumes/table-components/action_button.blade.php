<div class="d-flex justify-content-center">
    <a href="{{ route('download.all-resume', $row->id) }}"  class="download-link"
       data-bs-toggle="tooltip" title={{__('messages.common.download')}}>
        <i class="fas fa-download download-margin text-primary fs-3"></i>
    </a>
</div>
