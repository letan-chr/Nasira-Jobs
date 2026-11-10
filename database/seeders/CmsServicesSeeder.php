<?php

namespace Database\Seeders;

use App\Models\CmsServices;
use Illuminate\Database\Seeder;

class CmsServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            ['key' => 'home_title', 'value' => 'Join us & Explore Thousands of Jobs'],
            ['key' => 'home_description', 'value' => 'Find Jobs, Employment & Career Opportunities'],
            ['key' => 'home_banner', 'value' => 'front_web/images/hero-img.png'],
            ['key' => 'about_title_one', 'value' => 'Register'],
            ['key' => 'about_description_one', 'value' => 'Start by creating an account on our awesome platform'],
            ['key' => 'about_image_one', 'value' => 'front_web/images/register.png'],
            ['key' => 'about_title_two', 'value' => 'Submit Resume'],
            ['key' => 'about_description_two', 'value' => 'Fill out our forms and submit your resume right away'],
            ['key' => 'about_image_two', 'value' => 'front_web/images/resume.png'],
            ['key' => 'about_title_three', 'value' => 'Start Working'],
            ['key' => 'about_description_three',
                'value' => 'Start your new career by working with one of the most successful companies',
            ],
            ['key' => 'about_image_three', 'value' => 'front_web/images/working.png'],
        ];

        foreach ($input as $data) {
            $key = CmsServices::where('key', $data['key'])->first();
            if (isset($key)) {
                $key->update($data);
            } else {
                CmsServices::create($data);
            }
        }
    }
}
