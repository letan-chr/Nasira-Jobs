<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Role;

class RoleController extends AppBaseController
{
    public function __construct(private RoleRepository $roleRepository)
    {
    }

    /**
     * @return Factory|View
     */
    public function index(): View
    {
        return view('roles.index');
    }

    /**
     * @return Factory|View
     */
    public function create(): View
    {
        $permissions = $this->roleRepository->getPermissionsGrouped();

        return view('roles.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $this->roleRepository->store($request->validated());
        Flash::success(__('messages.flash.role_save'));

        return redirect()->route('roles.index');
    }

    /**
     * @return Factory|View
     */
    public function edit(Role $role): View
    {
        $permissions = $this->roleRepository->getPermissionsGrouped();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $isSystemRole = in_array($role->name, RoleRepository::SYSTEM_ROLES, true);

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions', 'isSystemRole'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->roleRepository->updateRole($role, $request->validated());
        Flash::success(__('messages.flash.role_update'));

        return redirect()->route('roles.index');
    }

    /**
     * @throws Exception
     */
    public function destroy(Role $role): JsonResponse
    {
        try {
            $this->roleRepository->deleteRole($role);

            return $this->sendSuccess(__('messages.flash.role_delete'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
