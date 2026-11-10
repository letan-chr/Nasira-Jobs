<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RoleRepository extends BaseRepository
{
    public const SYSTEM_ROLES = ['Admin', 'Employer', 'Candidate'];

    protected $fieldSearchable = [
        'name',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Role::class;
    }

    public function getPermissionsGrouped(): array
    {
        return Permission::orderBy('name')->get()->mapWithKeys(function (Permission $permission) {
            return [$permission->name => ucwords(str_replace('_', ' ', $permission->name))];
        })->toArray();
    }

    public function store(array $input): Role
    {
        try {
            DB::beginTransaction();

            /** @var Role $role */
            $role = Role::create([
                'name' => $input['name'],
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($input['permissions'] ?? []);
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            DB::commit();

            return $role->load('permissions');
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateRole(Role $role, array $input): Role
    {
        try {
            DB::beginTransaction();

            if (! in_array($role->name, self::SYSTEM_ROLES, true)) {
                $role->update([
                    'name' => $input['name'],
                ]);
            }

            $role->syncPermissions($input['permissions'] ?? []);
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            DB::commit();

            return $role->load('permissions');
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function deleteRole(Role $role): bool
    {
        if (in_array($role->name, self::SYSTEM_ROLES, true)) {
            throw new UnprocessableEntityHttpException(__('messages.flash.system_role_cant_delete'));
        }

        if ($role->users()->count() > 0) {
            throw new UnprocessableEntityHttpException(__('messages.flash.role_in_use'));
        }

        $role->syncPermissions([]);
        $role->delete();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return true;
    }
}
