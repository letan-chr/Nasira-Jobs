<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Employer',
            ],
            [
                'name' => 'Candidate',
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        /** @var Role $adminRole */
        $adminRole = Role::whereName('Admin')->first();

        /** @var User $user */
        $user = User::whereEmail('super@admin.com')->first();
        if ($user) {
            $user->assignRole($adminRole);
        }

        $this->call(DefaultPermissionSeeder::class);
    }
}
