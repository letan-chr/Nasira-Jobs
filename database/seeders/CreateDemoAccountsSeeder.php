<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\Candidates\CandidateRepository;
use App\Repositories\CompanyRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateDemoAccountsSeeder extends Seeder
{
    /**
     * Ensure demo login accounts exist with known credentials.
     */
    public function run(): void
    {
        $password = env('DEFAULT_DEMO_PASSWORD', 'NasiraDemo!ChangeMe2026');

        $admin = User::where('email', 'super@admin.com')->first()
            ?? User::where('email', 'admin@infyjobs.com')->first();

        if ($admin) {
            $admin->update([
                'email' => 'super@admin.com',
                'password' => Hash::make($password),
                'email_verified_at' => $admin->email_verified_at ?? Carbon::now(),
                'is_active' => 1,
            ]);
            $adminRole = Role::whereName('Admin')->first();
            if ($adminRole && ! $admin->hasRole('Admin')) {
                $admin->assignRole($adminRole);
            }
        }

        if (! User::where('email', 'company@admin.com')->exists()) {
            /** @var CompanyRepository $companyRepo */
            $companyRepo = App::make(CompanyRepository::class);
            $companyRepo->store([
                'name' => 'Demo Company',
                'email' => 'company@admin.com',
                'password' => $password,
                'is_verified' => 1,
                'ceo' => 'Demo CEO',
                'industry_id' => 1,
                'ownership_type_id' => 1,
                'company_size_id' => 1,
                'established_in' => 2020,
                'details' => 'Demo company account.',
                'location' => 'USA',
                'no_of_offices' => 1,
                'website' => 'https://example.com',
                'is_active' => 1,
                'is_featured' => 0,
                'is_default' => 1,
            ]);
        } else {
            User::where('email', 'company@admin.com')->update([
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now(),
                'is_active' => 1,
                'is_verified' => 1,
            ]);
        }

        if (! User::where('email', 'candidate@admin.com')->exists()) {
            /** @var CandidateRepository $candidateRepo */
            $candidateRepo = App::make(CandidateRepository::class);
            $candidateRepo->store([
                'first_name' => 'Demo',
                'last_name' => 'Candidate',
                'email' => 'candidate@admin.com',
                'password' => $password,
                'is_active' => 1,
                'is_verified' => 1,
                'current_salary' => 0,
                'expected_salary' => 0,
                'immediate_available' => 1,
            ]);
        } else {
            User::where('email', 'candidate@admin.com')->update([
                'password' => Hash::make($password),
                'email_verified_at' => Carbon::now(),
                'is_active' => 1,
                'is_verified' => 1,
            ]);
        }
    }
}
