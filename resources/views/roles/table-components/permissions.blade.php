<span class="badge bg-primary">
    {{ $row->permissions_count ?? $row->permissions()->count() }}
</span>
