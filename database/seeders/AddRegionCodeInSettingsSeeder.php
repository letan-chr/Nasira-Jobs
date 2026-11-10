<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class AddRegionCodeInSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phone = Setting::where(['key' => 'phone'])->first();
        if ($phone) {
            $phone->update(['value' => '0911759629']);
        }

        $region = Setting::where(['key' => 'region_code'])->first();
        if ($region) {
            $region->update(['value' => '251']);
        } else {
            Setting::create(['key' => 'region_code', 'value' => '251']);
        }
    }
}
