<div class="d-flex justify-content-center">
    @if($row->status == 3)
        <span class="badge bg-light-success" >{{ __('messages.common.hired') }}</span>
    @else
        <span class="badge bg-light-primary">{{ __('messages.common.ongoing') }}</span>
    @endif
</div>

