<?php

namespace Database\Seeders;

use App\Models\SalaryPeriod;
use Illuminate\Database\Seeder;

class CreateDefaultSalaryPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'period' => 'Weekly Pay Period',
                'description' => 'Weekly Pay Period',
                'is_default' => 1,
            ],
            [
                'period' => 'Every Other Week Pay Period',
                'description' => 'Every Other Week Pay Period',
                'is_default' => 1,
            ],
            [
                'period' => 'Semi Monthly Pay Period',
                'description' => 'Semi Monthly Pay Period',
                'is_default' => 1,
            ],
            [
                'period' => 'Monthly Pay Period',
                'description' => 'Monthly Pay Period',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            SalaryPeriod::create($data);
        }
    }
}
