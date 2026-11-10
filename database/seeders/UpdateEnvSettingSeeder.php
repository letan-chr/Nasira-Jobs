<?php

namespace Database\Seeders;

use App\Models\EnvSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateEnvSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            ['key' => 'paystack_key', 'value' => ''],
            ['key' => 'paystack_secret', 'value' => ''],
            ['key' => 'paystack_payment_url', 'value' => ''],
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
