<?php

namespace Database\Seeders;

use App\Models\EnvSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultEnvSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            ['key' => 'facebook_app_id', 'value' => ''],
            ['key' => 'facebook_app_secret', 'value' => ''],
            ['key' => 'facebook_redirect', 'value' => ''],
            ['key' => 'pusher_app_id', 'value' => ''],
            ['key' => 'pusher_app_key', 'value' => ''],
            ['key' => 'pusher_app_secret', 'value' => ''],
            ['key' => 'pusher_app_cluster', 'value' => ''],
            ['key' => 'stripe_key', 'value' => ''],
            ['key' => 'stripe_secret', 'value' => ''],
            ['key' => 'stripe_webhook_key', 'value' => ''],
            ['key' => 'paypal_client_id', 'value' => ''],
            ['key' => 'paypal_secret', 'value' => ''],
            ['key' => 'linkedin_client_id', 'value' => ''],
            ['key' => 'linkedin_client_secret', 'value' => ''],
            ['key' => 'google_client_id', 'value' => ''],
            ['key' => 'google_client_secret', 'value' => ''],
            ['key' => 'google_redirect', 'value' => ''],
            ['key' => 'cookie_consent_enabled', 'value' => ''],
        ];

        foreach ($input as $data) {
            $key = EnvSetting::where('key', $data['key'])->first();
            if (isset($key)) {
                $key->update($data);
            } else {
                EnvSetting::create($data);
            }
        }
    }
}
