<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CreateDefaultPostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $input = [
            [
                'name' => 'Job Experience',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
            [
                'name' => 'New Technology',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
            [
                'name' => 'Job Related',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
            [
                'name' => 'Company Culture',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
            [
                'name' => 'Job Applicants',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
            [
                'name' => 'Job Vacancy',
                'description' => $faker->realText(200),
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            PostCategory::create($data);
        }
    }
}
