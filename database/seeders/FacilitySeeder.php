<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::create([
            'name' => 'Edmonds Serenity AFH',
            'location' => 'Edmonds, WA',
            'description' => 'Our flagship facility providing compassionate care in a warm, home-like environment. Specializing in memory care and assisted living services.',
            'brochure_url' => '/brochures/edmonds-brochure.pdf',
            'brochure_color' => 'blue',
            'is_active' => true,
        ]);

        Facility::create([
            'name' => 'Bothell Serenity Corp',
            'location' => 'Bothell, WA',
            'description' => 'Our modern facility offering comprehensive care services with state-of-the-art amenities and personalized care plans.',
            'brochure_url' => '/brochures/bothell-brochure.pdf',
            'brochure_color' => 'green',
            'is_active' => true,
        ]);
    }
}