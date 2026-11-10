<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            [
                'name' => 'Computer Skill',
                'description' => 'Computer operating skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Communication Skill',
                'description' => 'Communication skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Customer service Skill',
                'description' => 'Customer service skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Interpersonal Skill',
                'description' => 'Interpersonal skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Leadership Skill',
                'description' => 'Leadership skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Management Skill',
                'description' => 'Management skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Problem-solving Skill',
                'description' => 'Problem-solving skill',
                'is_default' => 1,
            ],
            [
                'name' => 'Time management Skill',
                'description' => 'Time management skill',
                'is_default' => 1,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
