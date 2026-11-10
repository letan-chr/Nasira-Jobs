<?php

namespace Database\Seeders;

use App\Models\FunctionalArea;
use Illuminate\Database\Seeder;

class CreateDefaultFunctionalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'name' => 'Human Resource',
                'is_default' => 1,
            ],
            [
                'name' => 'Marketing/Promotion',
                'is_default' => 1,
            ],
            [
                'name' => 'Customer Service Support',
                'is_default' => 1,
            ],
            [
                'name' => 'Sales',
                'is_default' => 1,
            ],
            [
                'name' => 'Accounting and Finance',
                'is_default' => 1,
            ],
            [
                'name' => 'Distribution',
                'is_default' => 1,
            ],
            [
                'name' => 'Research and Development',
                'is_default' => 1,
            ],
            [
                'name' => 'Administrative/Management',
                'is_default' => 1,
            ],
            [
                'name' => 'Production',
                'is_default' => 1,
            ],
            [
                'name' => 'Operations',
                'is_default' => 1,
            ],
            [
                'name' => 'IT Support',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            FunctionalArea::create($data);
        }
    }
}
