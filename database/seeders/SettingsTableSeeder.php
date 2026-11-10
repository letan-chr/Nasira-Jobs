<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageUrl = 'assets/img/infyom-logo.png';
        $favicon = 'favicon.ico';
        $input = [
            ['key' => 'application_name', 'value' => 'Nasira Jobs'],
            ['key' => 'logo', 'value' => $imageUrl],
            ['key' => 'favicon', 'value' => $favicon],
            ['key' => 'company_description', 'value' => 'Your gateway to career opportunities in Ethiopia'],
            ['key' => 'address', 'value' => 'Addis Ababa, Ethiopia'],
            ['key' => 'phone', 'value' => '0911759629'],
            ['key' => 'email', 'value' => 'info@nasira.com'],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'google_plus_url', 'value' => ''],
            ['key' => 'linkedIn_url', 'value' => ''],
            ['key' => 'about_us', 'value' => 'Nasira Jobs connects talent with opportunity across Ethiopia. Find the latest job openings, internships, and career updates from trusted companies and organizations.'],
        ];

        foreach ($input as $data) {
            $key = Setting::where('key', $data['key'])->first();
            if (isset($key)) {
                $key->update($data);
            } else {
                Setting::create($data);
            }
        }
    }
}
