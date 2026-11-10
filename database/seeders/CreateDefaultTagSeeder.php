<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class CreateDefaultTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'name' => 'PHP',
                'is_default' => 1,
            ],
            [
                'name' => 'Laravel',
                'is_default' => 1,
            ],
            [
                'name' => 'HTML',
                'is_default' => 1,
            ],
            [
                'name' => 'CSS',
                'is_default' => 1,
            ],
            [
                'name' => 'Javascipt',
                'is_default' => 1,
            ],
            [
                'name' => 'Java',
                'is_default' => 1,
            ],
            [
                'name' => 'Python',
                'is_default' => 1,
            ],
            [
                'name' => 'Ruby',
                'is_default' => 1,
            ],
            [
                'name' => 'Android',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            Tag::create($data);
        }
    }
}
