<?php

namespace Database\Seeders;

use App\Models\OwnerShipType;
use Illuminate\Database\Seeder;

class CreateDefaultOwnerShipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerTypes = [
            [
                'name' => 'Sole Proprietorship',
                'description' => 'The sole proprietorship is the simplest business form under which one can operate a business.',
                'is_default' => 1,
            ],
            [
                'name' => 'Public',
                'description' => 'A company whose shares are traded freely on a stock exchange.',
                'is_default' => 1,
            ],
            [
                'name' => 'Private',
                'description' => 'A company whose shares may not be offered to the public for sale and which operates under legal requirements less strict than those for a public company.',
                'is_default' => 1,
            ],
            [
                'name' => 'Government',
                'description' => 'A government company is a company in which 51% or more of the paid-up capital is held by the Government or State Government.',
                'is_default' => 1,
            ],
            [
                'name' => 'NGO',
                'description' => 'A non-profit organization that operates independently of any government, typically one whose purpose is to address a social or political issue.',
                'is_default' => 1,
            ],
        ];

        foreach ($ownerTypes as $ownerType) {
            OwnerShipType::create($ownerType);
        }
    }
}
