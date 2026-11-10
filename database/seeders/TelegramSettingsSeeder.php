<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class TelegramSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'telegram_enabled' => '1',
            'telegram_bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
            'telegram_channel_id' => env('TELEGRAM_CHANNEL_ID', '@et_nasira'),
            'telegram_channel_name' => env('TELEGRAM_CHANNEL_NAME', 'Nasira Jobs'),
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
