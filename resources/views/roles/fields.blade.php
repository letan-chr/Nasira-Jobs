<div class="row">
    <div class="col-lg-6 mb-5">
        {{ Form::label('name', __('messages.role.name').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('name', isset($role) ? $role->name : null, [
            'class' => 'form-control',
            'required',
            'placeholder' => __('messages.role.name'),
            'readonly' => $isSystemRole,
        ]) }}
        @if ($isSystemRole)
            <small class="text-muted">{{ __('messages.role.system_role_hint') }}</small>
        @endif
    </div>
    <div class="col-12 mb-5">
        <div class="d-flex align-items-center justify-content-between mb-3">
            {{ Form::label('permissions', __('messages.role.permissions').':', ['class' => 'form-label mb-0']) }}
            <div>
                <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAllPermissions">
                    {{ __('messages.role.select_all') }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllPermissions">
                    {{ __('messages.role.clear_all') }}
                </button>
            </div>
        </div>
        <div class="row">
            @foreach ($permissions as $permissionName => $permissionLabel)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input role-permission-checkbox" type="checkbox"
                               name="permissions[]" value="{{ $permissionName }}"
                               id="permission_{{ $permissionName }}"
                               {{ in_array($permissionName, $rolePermissions ?? [], true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission_{{ $permissionName }}">
                            {{ $permissionLabel }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-12 d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAllPermissions');
        const clearAll = document.getElementById('clearAllPermissions');
        if (selectAll) {
            selectAll.addEventListener('click', function () {
                document.querySelectorAll('.role-permission-checkbox').forEach(function (el) {
                    el.checked = true;
                });
            });
        }
        if (clearAll) {
            clearAll.addEventListener('click', function () {
                document.querySelectorAll('.role-permission-checkbox').forEach(function (el) {
                    el.checked = false;
                });
            });
        }
    });
</script>
