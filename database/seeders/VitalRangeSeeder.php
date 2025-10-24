<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VitalRange;

class VitalRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranges = [
            // Blood Pressure - Systolic
            [
                'parameter' => 'systolic',
                'min_normal' => 90,
                'max_normal' => 120,
                'min_warning' => 80,
                'max_warning' => 139,
                'min_critical' => 60,
                'max_critical' => 180,
                'unit' => 'mmHg',
                'description' => 'Systolic blood pressure (upper number)',
                'is_active' => true,
            ],
            // Blood Pressure - Diastolic
            [
                'parameter' => 'diastolic',
                'min_normal' => 60,
                'max_normal' => 80,
                'min_warning' => 50,
                'max_warning' => 89,
                'min_critical' => 40,
                'max_critical' => 120,
                'unit' => 'mmHg',
                'description' => 'Diastolic blood pressure (lower number)',
                'is_active' => true,
            ],
            // Temperature
            [
                'parameter' => 'temperature',
                'min_normal' => 97.7,
                'max_normal' => 99.5,
                'min_warning' => 95.0,
                'max_warning' => 100.3,
                'min_critical' => 90.0,
                'max_critical' => 105.0,
                'unit' => '°F',
                'description' => 'Body temperature in Fahrenheit',
                'is_active' => true,
            ],
            // Pulse
            [
                'parameter' => 'pulse',
                'min_normal' => 60,
                'max_normal' => 100,
                'min_warning' => 50,
                'max_warning' => 110,
                'min_critical' => 40,
                'max_critical' => 150,
                'unit' => 'BPM',
                'description' => 'Heart rate in beats per minute',
                'is_active' => true,
            ],
            // Oxygen Saturation
            [
                'parameter' => 'oxygen_saturation',
                'min_normal' => 95,
                'max_normal' => 100,
                'min_warning' => 90,
                'max_warning' => 94,
                'min_critical' => 85,
                'max_critical' => 100,
                'unit' => '%',
                'description' => 'Blood oxygen saturation percentage',
                'is_active' => true,
            ],
        ];

        foreach ($ranges as $range) {
            VitalRange::firstOrCreate(
                ['parameter' => $range['parameter']],
                $range
            );
        }

        $this->command->info('Created ' . count($ranges) . ' vital ranges.');
    }
}
