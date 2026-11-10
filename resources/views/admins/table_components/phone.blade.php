<div class="d-flex align-items-center">
    <div class="d-flex flex-column">
        @if($row->phone)
            <span class="fs-6">{{ $row->phone }}</span>
        @else
            <span class="fs-6">{{__('messages.n/a')}}</span>
        @endif
    </div>
</div>
