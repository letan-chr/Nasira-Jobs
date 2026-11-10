<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class FooterLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageUrl = 'assets/img/infyom-logo.png';

        Setting::create(['key' => 'footer_logo', 'value' => $imageUrl]);
    }
}
