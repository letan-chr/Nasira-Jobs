<div class="menu-item">
    <a href="{{ route('candidates.create') }}" type="button" class="btn btn-primary">
        {{ __('messages.common.add') }}
    </a>
</div>
@if(Auth::user()->hasRole('Admin'))
    <div class="menu-item px-2">
        <a href="{{ route('candidates.export.excel') }}" type="button" class="btn btn-primary" >
            {{ __('messages.common.export_excel') }}
        </a>
    </div>
    @endif
