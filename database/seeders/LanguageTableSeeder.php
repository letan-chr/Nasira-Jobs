<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'language' => 'English',
                'iso_code' => 'en',
                'is_default' => 1,
            ],
            [
                'language' => 'French',
                'iso_code' => 'fr',
                'is_default' => 1,
            ],
            [
                'language' => 'German',
                'iso_code' => 'de',
                'is_default' => 1,
            ],
            [
                'language' => 'Arabic',
                'iso_code' => 'ar',
                'is_default' => 1,
            ], [
                'language' => 'Turkish',
                'iso_code' => 'tr',
                'is_default' => 1,
            ],
            [
                'language' => 'Spanish',
                'iso_code' => 'es',
                'is_default' => 1,
            ], [
                'language' => 'Portuguese',
                'iso_code' => 'pt',
                'is_default' => 1,
            ], [
                'language' => 'Russian',
                'iso_code' => 'ru',
                'is_default' => 1,
            ],[
                'language' => 'Chinese',
                'iso_code' => 'zh',
                'is_default' => 1,
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
