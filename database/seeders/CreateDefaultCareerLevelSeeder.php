<?php

namespace Database\Seeders;

use App\Models\CareerLevel;
use Illuminate\Database\Seeder;

class CreateDefaultCareerLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'level_name' => 'Entry',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Intermediate',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Senior',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Highly Skilled',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Specialist',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Developing',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Advanced',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Expert',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Principal',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Supervisor',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Sr. Supervisor',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Manager',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Sr. Manager',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Director',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Sr. Director',
                'is_default' => 1,
            ],
            [
                'level_name' => 'Vice President',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            CareerLevel::create($data);
        }
    }
}
