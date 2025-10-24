<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\Resident;
use App\Models\User;
use App\Models\Branch;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::all();
        $caregivers = User::whereHas('roles', function($query) {
            $query->where('name', 'caregiver');
        })->get();
        $branches = Branch::all();

        if ($residents->isEmpty() || $caregivers->isEmpty() || $branches->isEmpty()) {
            $this->command->warn('No residents, caregivers, or branches found. Please run ResidentSeeder, UserSeeder, and BranchSeeder first.');
            return;
        }

        // No assignment types, statuses, or priorities in the table structure

        $assignedPairs = [];
        
        foreach ($residents as $resident) {
            // Assign 1-2 caregivers per resident
            $assignmentCount = rand(1, 2);
            $availableCaregivers = $caregivers->where('branch_id', $resident->branch_id);
            
            if ($availableCaregivers->isEmpty()) {
                continue;
            }
            
            $assignedCaregivers = $availableCaregivers->random(min($assignmentCount, $availableCaregivers->count()));
            
            foreach ($assignedCaregivers as $caregiver) {
                $pairKey = $resident->id . '_' . $caregiver->id;
                
                // Skip if this pair already exists
                if (in_array($pairKey, $assignedPairs)) {
                    continue;
                }
                
                $assignedAt = Carbon::now()->subDays(rand(1, 180));
                $assignedBy = $caregivers->random();
                
                Assignment::create([
                    'resident_id' => $resident->id,
                    'caregiver_id' => $caregiver->id,
                    'branch_id' => $resident->branch_id,
                    'assigned_at' => $assignedAt,
                    'assigned_by' => $assignedBy->id,
                    'notes' => $this->generateAssignmentNotes(),
                    'is_active' => true, // Only create active assignments
                    'created_at' => $assignedAt,
                    'updated_at' => $assignedAt,
                ]);
                
                $assignedPairs[] = $pairKey;
            }
        }

        $this->command->info('AssignmentSeeder completed successfully!');
    }


    private function generateAssignmentNotes(): string
    {
        $notes = [
            'Assignment started successfully. Resident is comfortable with caregiver.',
            'Good rapport established. Care plan is being followed effectively.',
            'Regular communication with family members maintained.',
            'Caregiver shows excellent attention to detail.',
            'Resident has shown improvement since assignment began.',
            'Assignment is progressing well with positive outcomes.',
            'Caregiver demonstrates strong professional skills.',
            'Resident and family are satisfied with care provided.',
            'Assignment continues to meet all care objectives.',
            'Excellent working relationship established.',
        ];

        return $notes[array_rand($notes)];
    }
}
