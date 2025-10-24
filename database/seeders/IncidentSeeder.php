<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::all();
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['administrator', 'super_admin', 'caregiver']);
        })->get();

        if ($residents->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No residents or users found. Please run ResidentSeeder and UserSeeder first.');
            return;
        }

        $incidentTypes = [
            'Fall',
            'Medication Error',
            'Behavioral Incident',
            'Medical Emergency',
            'Equipment Malfunction',
            'Security Breach',
            'Fire/Safety',
            'Food Safety',
            'Infection Control',
            'Transportation',
            'Communication Error',
            'Environmental Hazard',
            'Staff Injury',
            'Resident Injury',
            'Property Damage'
        ];

        $severityLevels = ['low', 'medium', 'high', 'critical'];
        $statuses = ['reported', 'investigating', 'resolved', 'closed', 'pending_review'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        foreach ($residents as $resident) {
            // Create 1-4 incidents per resident
            $incidentCount = rand(1, 4);
            
            for ($i = 0; $i < $incidentCount; $i++) {
                $occurredAt = Carbon::now()->subDays(rand(1, 180));
                
                Incident::create([
                    'created_at' => $occurredAt,
                    'updated_at' => $occurredAt,
                ]);
            }
        }

        $this->command->info('IncidentSeeder completed successfully!');
    }

}
