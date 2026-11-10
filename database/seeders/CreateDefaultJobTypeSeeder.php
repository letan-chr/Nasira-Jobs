<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Seeder;

class CreateDefaultJobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'name' => 'Architecture and Engineering',
                'description' => 'Architecture and Engineering',
                'is_default' => 1,
            ],
            [
                'name' => 'Arts, Design, Entertainment, Sports, and Media',
                'description' => 'Arts, Design, Entertainment, Sports, and Media',
                'is_default' => 1,
            ],
            [
                'name' => 'Building and Grounds Cleaning and Maintenance',
                'description' => 'Building and Grounds Cleaning and Maintenance',
                'is_default' => 1,
            ],
            [
                'name' => 'Business and Financial Operations',
                'description' => 'Business and Financial Operations',
                'is_default' => 1,
            ],
            [
                'name' => 'Community and Social Services',
                'description' => 'Community and Social Services',
                'is_default' => 1,
            ],
            [
                'name' => 'Computer and Mathematical',
                'description' => 'Computer and Mathematical',
                'is_default' => 1,
            ],
            [
                'name' => 'Construction and Extraction',
                'description' => 'Construction and Extraction',
                'is_default' => 1,
            ],
            [
                'name' => 'Education, Training, and Library',
                'description' => 'Education, Training, and Library',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            JobType::create($data);
        }
    }
}
