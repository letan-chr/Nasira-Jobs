<?php

namespace Database\Seeders;

use App\Models\JobShift;
use Illuminate\Database\Seeder;

class CreateDefaultJobShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'shift' => 'First Shift',
                'description' => 'First Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Second Shift',
                'description' => 'Second Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Third Shift',
                'description' => 'Third Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Fixed Shift',
                'description' => 'Fixed Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Rotating Shift',
                'description' => 'Rotating Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Split Shift',
                'description' => 'Split Shift',
                'is_default' => 1,
            ], [
                'shift' => 'On-call Shift',
                'description' => 'On-call Shift',
                'is_default' => 1,
            ], [
                'shift' => 'Weekday or weekend Shift',
                'description' => 'Weekday or Weekend Shift',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            JobShift::create($data);
        }
    }
}
