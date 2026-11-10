<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use App\Models\User;
use App\Repositories\PostRepository;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CreateDefaultPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var PostRepository $blogRepo */
        $blogRepo = App::make(PostRepository::class);
        $blogCategories = PostCategory::pluck('id')->toArray();

        $faker = Faker::create();

        $input = [
            [
                'title' => 'Benefits of Having Experience While Applying For a Job',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
            [
                'title' => 'Types of Candidates',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
            [
                'title' => 'Learn About Information Technology',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
            [
                'title' => 'Characteristics of Best Employer',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
            [
                'title' => 'Importance of Training',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
            [
                'title' => 'Characteristics of Best Employee',
                'description' => $faker->realText(1000),
                'blogCategories' => array_rand($blogCategories),
                'is_default' => 1,
            ],
        ];
        $userId = User::whereEmail('super@admin.com')->pluck('id');
        Auth::loginUsingId($userId);

        foreach ($input as $data) {
            $blogRepo->store($data);
        }
    }
}
