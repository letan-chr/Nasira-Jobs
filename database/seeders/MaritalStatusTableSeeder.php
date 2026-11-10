<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'marital_status' => 'Married',
                'description' => 'Married',
                'is_default' => 1,
            ],
            [
                'marital_status' => 'Widowed',
                'description' => 'Widowed',
                'is_default' => 1,
            ],
            [
                'marital_status' => 'Separated',
                'description' => 'Separated',
                'is_default' => 1,
            ],
            [
                'marital_status' => 'Divorced',
                'description' => 'Divorced',
                'is_default' => 1,
            ],
            [
                'marital_status' => 'Single',
                'description' => 'Single',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            MaritalStatus::create($data);
        }
    }
}
