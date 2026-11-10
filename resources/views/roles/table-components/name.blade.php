<span class="text-decoration-none">
    {{ $row->name }}
    @if (in_array($row->name, \App\Repositories\RoleRepository::SYSTEM_ROLES, true))
        <span class="badge bg-info ms-1">{{ __('messages.role.system') }}</span>
    @endif
</span>
