<?php

namespace Database\Seeders;

use App\Models\RequiredDegreeLevel;
use Illuminate\Database\Seeder;

class CreateDefaultDegreeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            [
                'name' => 'Associate of Arts (A.A.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Associate of Science (A.S.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Associate of Applied Science (AAS)',
                'is_default' => 1,
            ],
            [
                'name' => 'Bachelor of Arts (B.A.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Bachelor of Science (B.S.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Bachelor of Fine Arts (BFA)',
                'is_default' => 1,
            ],
            [
                'name' => 'Bachelor of Applied Science (BAS)',
                'is_default' => 1,
            ],
            [
                'name' => 'Master of Arts (M.A.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Master of Science (M.S.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Master of Business Administration (MBA)',
                'is_default' => 1,
            ],
            [
                'name' => 'Master of Fine Arts (MFA)',
                'is_default' => 1,
            ],
            [
                'name' => 'Doctor of Philosophy (Ph.D.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Juris Doctor (J.D.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Doctor of Medicine (M.D.)',
                'is_default' => 1,
            ],
            [
                'name' => 'Doctor of Dental Surgery (DDS)',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $data) {
            RequiredDegreeLevel::create($data);
        }
    }
}
