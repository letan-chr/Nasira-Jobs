<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DefaultLastChangeBySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = getSuperAdmin()->id;
        Job::whereNull('last_change')->update(['last_change' => $adminId]);
        Company::whereNull('last_change')->update(['last_change' => $adminId]);
        Candidate::whereNull('last_change')->update(['last_change' => $adminId]);
        Transaction::whereNull('approved_id')->where('is_approved', '!=', Transaction::PENDING)->update(['approved_id' => $adminId]);
    }
}
