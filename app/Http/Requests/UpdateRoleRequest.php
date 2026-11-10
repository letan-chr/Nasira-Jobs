<?php

namespace App\Http\Requests;

use App\Repositories\RoleRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $role = $this->route('role');
        $isSystem = in_array($role->name, RoleRepository::SYSTEM_ROLES, true);

        return [
            'name' => [
                $isSystem ? 'nullable' : 'required',
                'string',
                'max:125',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }
}
