<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Class AddIsSliderActiveDeactive
 */
class AddIsSliderActiveDeactiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exist = Setting::where('key', 'is_slider_active')->exists();
        if (! $exist) {
            Setting::create(['key' => 'is_slider_active', 'value' => '1']);
        }
    }
}
