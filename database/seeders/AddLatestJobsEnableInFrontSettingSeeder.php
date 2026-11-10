<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use Illuminate\Database\Seeder;

class AddLatestJobsEnableInFrontSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FrontSetting::create(['key' => 'latest_jobs_enable', 'value' => false]);
    }
}
