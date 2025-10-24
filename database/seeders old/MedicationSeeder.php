<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medication;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residents = Resident::all();
        $admin = User::where('email', 'admin@edmondserenity.com')->first();

        if ($residents->isEmpty() || !$admin) {
            $this->command->warn('No residents or admin user found. Please run other seeders first.');
            return;
        }

        // Create medications for all residents
        $medicationsData = [];
        
        // Get all residents
        $allResidents = $residents->toArray();
        
        // Define medication templates for different conditions
        $medicationTemplates = [
            // Diabetes medications
            [
                'name' => 'Metformin',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Type 2 Diabetes',
                'notes' => 'Take with meals to reduce stomach upset.',
            ],
            [
                'name' => 'Insulin Glargine',
                'instructions' => 'q.d',
                'quantity' => 30,
                'diagnosis' => 'Type 1 Diabetes',
                'notes' => 'Take at the same time daily.',
            ],
            // Heart medications
            [
                'name' => 'Lisinopril',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Hypertension',
                'notes' => 'Monitor blood pressure regularly.',
            ],
            [
                'name' => 'Atorvastatin',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'High Cholesterol',
                'notes' => 'Take at bedtime for best effectiveness.',
            ],
            [
                'name' => 'Aspirin',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Heart Protection',
                'notes' => 'Low dose aspirin for heart protection.',
            ],
            // Dementia medications
            [
                'name' => 'Donepezil',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'Alzheimer\'s Disease',
                'notes' => 'Take at bedtime for best absorption.',
            ],
            [
                'name' => 'Memantine',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Dementia',
                'notes' => 'May cause dizziness, monitor for falls.',
            ],
            // Pain medications
            [
                'name' => 'Ibuprofen',
                'instructions' => 'PRN',
                'quantity' => 100,
                'diagnosis' => 'Arthritis',
                'notes' => 'Take as needed for pain, not more than 3 times daily.',
            ],
            [
                'name' => 'Acetaminophen',
                'instructions' => 'PRN',
                'quantity' => 100,
                'diagnosis' => 'Pain Relief',
                'notes' => 'Alternative pain relief, can be taken with ibuprofen.',
            ],
            // Bone health
            [
                'name' => 'Calcium Carbonate',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Osteoporosis',
                'notes' => 'Take with food to improve absorption.',
            ],
            [
                'name' => 'Vitamin D3',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Bone Health',
                'notes' => 'Essential for calcium absorption.',
            ],
            // Parkinson's medications
            [
                'name' => 'Carbidopa-Levodopa',
                'instructions' => 't.i.d',
                'quantity' => 90,
                'diagnosis' => 'Parkinson\'s Disease',
                'notes' => 'Take 30 minutes before meals for best effect.',
            ],
            [
                'name' => 'Pramipexole',
                'instructions' => 't.i.d',
                'quantity' => 90,
                'diagnosis' => 'Parkinson\'s Disease',
                'notes' => 'May cause sleepiness, monitor for drowsiness.',
            ],
            // COPD medications
            [
                'name' => 'Albuterol Inhaler',
                'instructions' => 'PRN',
                'quantity' => 1,
                'diagnosis' => 'COPD',
                'notes' => 'Use as needed for breathing difficulties.',
            ],
            [
                'name' => 'Tiotropium',
                'instructions' => 'q.d',
                'quantity' => 30,
                'diagnosis' => 'COPD',
                'notes' => 'Long-acting bronchodilator, take once daily.',
            ],
            // Eye medications
            [
                'name' => 'Latanoprost Eye Drops',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'Glaucoma',
                'notes' => 'Apply to both eyes at bedtime.',
            ],
            // General health
            [
                'name' => 'Multivitamin',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'General Health',
                'notes' => 'Daily vitamin supplement.',
            ],
            [
                'name' => 'Loratadine',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Allergies',
                'notes' => 'Take during allergy season, may cause drowsiness.',
            ],
        ];
        
        // Assign 1-3 medications to each resident
        foreach ($allResidents as $resident) {
            $residentName = $resident['name'];
            $medicationCount = rand(1, 3); // Each resident gets 1-3 medications
            $selectedMedications = array_rand($medicationTemplates, $medicationCount);
            
            if (!is_array($selectedMedications)) {
                $selectedMedications = [$selectedMedications];
            }
            
            foreach ($selectedMedications as $medIndex) {
                $template = $medicationTemplates[$medIndex];
                $startDate = Carbon::now()->subDays(rand(30, 90));
                $endDate = $startDate->copy()->addDays(rand(60, 120));
                
                $medicationsData[] = [
                    'resident_name' => $residentName,
                    'name' => $template['name'],
                    'instructions' => $template['instructions'],
                    'quantity' => $template['quantity'],
                    'diagnosis' => $template['diagnosis'],
                    'prescription_date' => $startDate->format('Y-m-d'),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'notes' => $template['notes'],
                    'is_active' => true,
                ];
            }
        }

        // Get all available drugs
        $drugs = \App\Models\Drug::all();
        
        foreach ($medicationsData as $data) {
            $resident = $residents->where('name', $data['resident_name'])->first();
            
            if ($resident) {
                // Find matching drug by name
                $drug = $drugs->where('name', $data['name'])->first();
                
                // If drug not found, create a generic one or use the first available
                if (!$drug) {
                    $drug = $drugs->first();
                }
                
                Medication::create([
                    'resident_id' => $resident->id,
                    'drug_id' => $drug ? $drug->id : null,
                    'name' => $data['name'],
                    'instructions' => $data['instructions'],
                    'quantity' => $data['quantity'],
                    'diagnosis' => $data['diagnosis'],
                    'prescription_date' => Carbon::parse($data['prescription_date']),
                    'start_date' => Carbon::parse($data['start_date']),
                    'end_date' => Carbon::parse($data['end_date']),
                    'notes' => $data['notes'],
                    'is_active' => $data['is_active'],
                    'created_by' => $admin->id,
                ]);
            }
        }

        $this->command->info('Medications seeded successfully!');
    }
}
