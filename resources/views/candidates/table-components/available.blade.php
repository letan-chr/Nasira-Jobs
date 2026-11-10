<div class="d-flex justify-content-center">
    @if($row->immediate_available == 1)
        <div class="badge bg-light-info">
            <div>
                {{ __('messages.candidate.immediate_available') }}
            </div>
        </div>
    @else
        <div class="badge bg-light-danger">
            <div>
                {{ __('messages.candidate.not_immediate_available') }}
            </div>
        </div>
    @endif
</div>

