<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Application permissions available for dynamic role assignment.
     */
    public static function permissions(): array
    {
        return [
            'access_admin_panel' => 'Access Admin Panel',
            'manage_dashboard' => 'Manage Dashboard',
            'manage_employers' => 'Manage Employers',
            'manage_admins' => 'Manage Admins',
            'manage_candidates' => 'Manage Candidates',
            'manage_jobs' => 'Manage Jobs',
            'manage_blogs' => 'Manage Blogs',
            'manage_subscriptions' => 'Manage Subscriptions',
            'manage_subscribers' => 'Manage Subscribers',
            'manage_countries' => 'Manage Countries',
            'manage_general' => 'Manage General Settings Data',
            'manage_cms' => 'Manage CMS',
            'manage_cms_sliders' => 'Manage CMS Sliders',
            'manage_front_cms' => 'Manage Front CMS',
            'manage_roles' => 'Manage Roles & Permissions',
            'manage_settings' => 'Manage Settings',
        ];
    }

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::permissions() as $name => $label) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['name' => $name, 'guard_name' => 'web']
            );
        }

        $allPermissions = Permission::pluck('name')->toArray();

        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions($allPermissions);
        }

        $employerRole = Role::where('name', 'Employer')->first();
        if ($employerRole) {
            $employerRole->syncPermissions([]);
        }

        $candidateRole = Role::where('name', 'Candidate')->first();
        if ($candidateRole) {
            $candidateRole->syncPermissions([]);
        }
    }
}
