<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class UserRepository
 *
 * @version January 11, 2020, 11:09 am UTC
 */
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function store(array $input): User
    {
        try {
            /** @var User $user */
            $user = User::create($input);
            $this->assignRoles($user, $input);

            return $user;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function profileUpdate(array $input): bool
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            $user->update($input);

            if ((isset($input['image']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['image'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function changePassword(array $input): bool
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            if (! Hash::check($input['password_current'], $user->password)) {
                throw new UnprocessableEntityHttpException(__('messages.user.password_invalid'));
            }
            $input['password'] = Hash::make($input['password']);
            $user->update($input);

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function adminStore($input): User
    {
        try {
            /** @var User $user */
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);

            if ((isset($input['profile']))) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['profile'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            $roleName = $input['role'] ?? 'Admin';
            $role = Role::where('name', $roleName)
                ->whereNotIn('name', ['Employer', 'Candidate'])
                ->first() ?: Role::where('name', 'Admin')->first();
            $user->assignRole($role);

            return $user;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateAdmin($user, $input): bool
    {
        try {
            /** @var User $user */
            if (! empty($input['update_password'])) {
                $input['password'] = Hash::make($input['update_password']);
            }

            $user->update($input);

            if (isset($input['profile']) && ! empty($input['profile'])) {
                $user->clearMediaCollection(User::PROFILE);
                $user->addMedia($input['profile'])
                    ->toMediaCollection(User::PROFILE, config('app.media_disc'));
            }

            if (! empty($input['role'])) {
                $role = Role::where('name', $input['role'])
                    ->whereNotIn('name', ['Employer', 'Candidate'])
                    ->first();
                if ($role) {
                    $user->syncRoles([$role]);
                }
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }
}
