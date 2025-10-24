<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create facilities
        $edmondsFacility = Facility::firstOrCreate(
            ['name' => 'Edmonds Serenity AFH'],
            [
                'location' => 'Edmonds, WA',
                'description' => 'Our flagship facility providing compassionate care in a warm, home-like environment.',
                'brochure_url' => '/brochures/edmonds-brochure.pdf',
                'brochure_color' => 'blue',
                'is_active' => true,
            ]
        );

        $bothellFacility = Facility::firstOrCreate(
            ['name' => 'Bothell Serenity Corp'],
            [
                'location' => 'Bothell, WA',
                'description' => 'A modern facility offering advanced care services with a focus on rehabilitation.',
                'brochure_url' => '/brochures/bothell-brochure.pdf',
                'brochure_color' => 'green',
                'is_active' => true,
            ]
        );

        // Create branches
        $branches = [
            [
                'name' => '1st Edmonds AFH',
                'address' => '123 Main Street, Edmonds, WA 98020',
                'facility_id' => $edmondsFacility->id,
                'phone' => '(425) 555-0101',
                'email' => 'edmonds1@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => 'Canyon Park Serenity AFH',
                'address' => '456 Canyon Park Blvd, Bothell, WA 98011',
                'facility_id' => $bothellFacility->id,
                'phone' => '(425) 555-0102',
                'email' => 'canyonpark@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => 'Serenity Everett AFH',
                'address' => '789 Everett Ave, Everett, WA 98201',
                'facility_id' => $edmondsFacility->id,
                'phone' => '(425) 555-0103',
                'email' => 'everett@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => 'Bothell Serenity AFH',
                'address' => '321 Bothell Way, Bothell, WA 98012',
                'facility_id' => $bothellFacility->id,
                'phone' => '(425) 555-0104',
                'email' => 'bothell@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => 'Lynnwood Serenity AFH',
                'address' => '654 Lynnwood Dr, Lynnwood, WA 98036',
                'facility_id' => $edmondsFacility->id,
                'phone' => '(425) 555-0105',
                'email' => 'lynnwood@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => '1st Edmond – Best Care Harbour Pointe – Mukiteo',
                'address' => '987 Harbour Pointe Blvd, Mukilteo, WA 98275',
                'facility_id' => $edmondsFacility->id,
                'phone' => '(425) 555-0106',
                'email' => 'harbourpointe@serenityafh.com',
                'is_active' => true,
            ],
            [
                'name' => 'Filbert Rd AFH',
                'address' => '147 Filbert Rd, Edmonds, WA 98026',
                'facility_id' => $edmondsFacility->id,
                'phone' => '(425) 555-0107',
                'email' => 'filbert@serenityafh.com',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branchData) {
            Branch::firstOrCreate(
                ['name' => $branchData['name']],
                $branchData
            );
        }
    }
}