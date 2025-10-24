<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AppointmentType;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointmentTypes = [
            [
                'name' => 'Clinician',
                'description' => 'Medical professional visits',
                'color_code' => '#3B82F6',
                'default_duration' => 60,
            ],
            [
                'name' => 'Counsellor',
                'description' => 'Therapy and counseling sessions',
                'color_code' => '#10B981',
                'default_duration' => 45,
            ],
            [
                'name' => 'Primary Care Provider (DCPA)',
                'description' => 'Main healthcare provider appointments',
                'color_code' => '#F59E0B',
                'default_duration' => 30,
            ],
            [
                'name' => 'Other',
                'description' => 'Miscellaneous appointments and injections',
                'color_code' => '#6B7280',
                'default_duration' => 15,
            ],
            [
                'name' => 'Specialist',
                'description' => 'Specialist medical consultations',
                'color_code' => '#8B5CF6',
                'default_duration' => 60,
            ],
            [
                'name' => 'Dental',
                'description' => 'Oral health appointments',
                'color_code' => '#EC4899',
                'default_duration' => 45,
            ],
            [
                'name' => 'Vision',
                'description' => 'Eye care appointments',
                'color_code' => '#06B6D4',
                'default_duration' => 30,
            ],
            [
                'name' => 'Therapy',
                'description' => 'Physical or occupational therapy',
                'color_code' => '#84CC16',
                'default_duration' => 60,
            ],
        ];

        foreach ($appointmentTypes as $type) {
            AppointmentType::create($type);
        }
    }
}
