<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VitalSign;
use App\Models\Resident;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;

class VitalSignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user as the creator
        $user = User::first();
        if (!$user) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Get residents and branches
        $residents = Resident::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        if ($residents->isEmpty() || $branches->isEmpty()) {
            $this->command->error('No residents or branches found. Please run ResidentSeeder and BranchSeeder first.');
            return;
        }

        // Sample vital signs data
        $vitalSignsData = [
            // Normal readings
            [
                'systolic' => 120,
                'diastolic' => 80,
                'temperature' => 98.6,
                'pulse' => 72,
                'oxygen_saturation' => 98,
                'pain_level' => 0,
                'status' => 'approved',
                'notes' => 'All vital signs within normal range',
            ],
            [
                'systolic' => 115,
                'diastolic' => 75,
                'temperature' => 98.2,
                'pulse' => 68,
                'oxygen_saturation' => 99,
                'pain_level' => 1,
                'status' => 'approved',
                'notes' => 'Excellent vital signs',
            ],
            [
                'systolic' => 110,
                'diastolic' => 70,
                'temperature' => 97.8,
                'pulse' => 65,
                'oxygen_saturation' => 97,
                'pain_level' => 0,
                'status' => 'approved',
                'notes' => 'Stable vital signs',
            ],
            // Warning readings
            [
                'systolic' => 135,
                'diastolic' => 85,
                'temperature' => 100.1,
                'pulse' => 95,
                'oxygen_saturation' => 92,
                'pain_level' => 3,
                'status' => 'pending_review',
                'notes' => 'Elevated blood pressure and temperature - needs monitoring',
            ],
            [
                'systolic' => 130,
                'diastolic' => 88,
                'temperature' => 99.8,
                'pulse' => 88,
                'oxygen_saturation' => 94,
                'pain_level' => 2,
                'status' => 'pending_review',
                'notes' => 'Slightly elevated readings',
            ],
            // Critical readings
            [
                'systolic' => 180,
                'diastolic' => 110,
                'temperature' => 102.5,
                'pulse' => 120,
                'oxygen_saturation' => 88,
                'pain_level' => 8,
                'status' => 'critical',
                'notes' => 'CRITICAL: Immediate medical attention required',
            ],
            [
                'systolic' => 160,
                'diastolic' => 95,
                'temperature' => 101.8,
                'pulse' => 110,
                'oxygen_saturation' => 90,
                'pain_level' => 6,
                'status' => 'critical',
                'notes' => 'Critical readings - notify physician immediately',
            ],
            // Declined readings
            [
                'systolic' => null,
                'diastolic' => null,
                'temperature' => null,
                'pulse' => null,
                'oxygen_saturation' => null,
                'pain_level' => null,
                'status' => 'declined',
                'reason_declined' => 'Resident refused vital signs measurement',
                'notes' => 'Resident was agitated and refused all measurements',
            ],
            [
                'systolic' => null,
                'diastolic' => null,
                'temperature' => 98.6,
                'pulse' => null,
                'oxygen_saturation' => null,
                'pain_level' => null,
                'status' => 'declined',
                'reason_declined' => 'Unable to obtain blood pressure due to equipment malfunction',
                'notes' => 'BP cuff not working properly',
            ],
        ];

        // Generate additional random vital signs
        $additionalVitalSigns = [];
        for ($i = 0; $i < 15; $i++) {
            $resident = $residents->random();
            // Use the resident's assigned branch, not a random one
            $branchId = $resident->branch_id;
            
            // Generate random but realistic vital signs
            $systolic = rand(90, 160);
            $diastolic = rand(60, 100);
            $temperature = round(rand(970, 1010) / 10, 1);
            $pulse = rand(55, 110);
            $oxygenSaturation = rand(88, 100);
            $painLevel = rand(0, 5);
            
            // Determine status based on values
            $status = 'approved';
            if ($systolic >= 140 || $diastolic >= 90 || $temperature >= 100.4 || $oxygenSaturation < 90) {
                $status = 'critical';
            } elseif ($systolic >= 130 || $diastolic >= 85 || $temperature >= 99.5 || $oxygenSaturation < 95) {
                $status = 'pending_review';
            }

            $additionalVitalSigns[] = [
                'resident_id' => $resident->id,
                'branch_id' => $branchId,
                'measurement_date' => Carbon::now()->subDays(rand(0, 30)),
                'systolic' => $systolic,
                'diastolic' => $diastolic,
                'temperature' => $temperature,
                'pulse' => $pulse,
                'oxygen_saturation' => $oxygenSaturation,
                'pain_level' => $painLevel,
                'status' => $status,
                'notes' => 'Routine vital signs measurement',
                'taken_by' => $user->id,
            ];
        }

        // Create vital signs for each resident
        foreach ($residents as $resident) {
            // Use the resident's assigned branch, not a random one
            $branchId = $resident->branch_id;
            
            foreach ($vitalSignsData as $vitalData) {
                VitalSign::create([
                    'resident_id' => $resident->id,
                    'branch_id' => $branchId,
                    'measurement_date' => Carbon::now()->subDays(rand(0, 7)),
                    'systolic' => $vitalData['systolic'],
                    'diastolic' => $vitalData['diastolic'],
                    'temperature' => $vitalData['temperature'],
                    'pulse' => $vitalData['pulse'],
                    'oxygen_saturation' => $vitalData['oxygen_saturation'],
                    'pain_level' => $vitalData['pain_level'],
                    'pain_description' => $vitalData['pain_level'] > 0 ? 'Mild discomfort reported' : null,
                    'reason_declined' => $vitalData['reason_declined'] ?? null,
                    'status' => $vitalData['status'],
                    'notes' => $vitalData['notes'],
                    'taken_by' => $user->id,
                ]);
            }
        }

        // Create additional random vital signs
        foreach ($additionalVitalSigns as $vitalData) {
            VitalSign::create($vitalData);
        }

        $totalVitalSigns = count($vitalSignsData) * $residents->count() + count($additionalVitalSigns);
        $this->command->info("Created {$totalVitalSigns} sample vital signs records.");
    }
}
