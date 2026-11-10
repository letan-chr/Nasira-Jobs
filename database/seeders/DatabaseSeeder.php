<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DefaultPermissionSeeder::class,
            CreateDemoAccountsSeeder::class,
            TestDataSeeder::class,
            CvTemplateSeeder::class,
            TelegramSettingsSeeder::class,
        ]);
    }
}
