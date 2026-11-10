<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

class NotificationSettingModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'key' => 'JOB_ALERT',
                'value' => true,
            ],
        ];
        foreach ($input as $data) {
            $module = NotificationSetting::where('key', $data['key'])->first();
            if ($module) {
                $module->update(['value' => $data['value']]);
            } else {
                NotificationSetting::create($data);
            }
        }
    }
}
