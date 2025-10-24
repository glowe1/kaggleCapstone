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

        $medicationsData = [
            [
                'resident_name' => 'Margaret Thompson',
                'name' => 'Metformin',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Type 2 Diabetes',
                'prescription_date' => '2024-09-15',
                'start_date' => '2024-09-16',
                'end_date' => '2024-12-16',
                'notes' => 'Take with meals to reduce stomach upset.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Margaret Thompson',
                'name' => 'Lisinopril',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Hypertension',
                'prescription_date' => '2024-09-10',
                'start_date' => '2024-09-11',
                'end_date' => '2024-12-11',
                'notes' => 'Monitor blood pressure regularly.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Robert Davis',
                'name' => 'Donepezil',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'Mild Dementia',
                'prescription_date' => '2024-08-20',
                'start_date' => '2024-08-21',
                'end_date' => '2024-11-21',
                'notes' => 'Take at bedtime for best absorption.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Robert Davis',
                'name' => 'Memantine',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Mild Dementia',
                'prescription_date' => '2024-08-20',
                'start_date' => '2024-08-21',
                'end_date' => '2024-11-21',
                'notes' => 'May cause dizziness, monitor for falls.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Elizabeth Miller',
                'name' => 'Ibuprofen',
                'instructions' => 'PRN',
                'quantity' => 100,
                'diagnosis' => 'Arthritis',
                'prescription_date' => '2024-07-15',
                'start_date' => '2024-07-16',
                'end_date' => '2025-01-16',
                'notes' => 'Take as needed for pain, not more than 3 times daily.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Elizabeth Miller',
                'name' => 'Acetaminophen',
                'instructions' => 'PRN',
                'quantity' => 100,
                'diagnosis' => 'Arthritis',
                'prescription_date' => '2024-07-15',
                'start_date' => '2024-07-16',
                'end_date' => '2025-01-16',
                'notes' => 'Alternative pain relief, can be taken with ibuprofen.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'William Wilson',
                'name' => 'Atorvastatin',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'Heart Condition',
                'prescription_date' => '2024-09-01',
                'start_date' => '2024-09-02',
                'end_date' => '2024-12-02',
                'notes' => 'Take at bedtime for best effectiveness.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'William Wilson',
                'name' => 'Aspirin',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Heart Condition',
                'prescription_date' => '2024-09-01',
                'start_date' => '2024-09-02',
                'end_date' => '2024-12-02',
                'notes' => 'Low dose aspirin for heart protection.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Patricia Moore',
                'name' => 'Calcium Carbonate',
                'instructions' => 'b.i.d',
                'quantity' => 60,
                'diagnosis' => 'Osteoporosis',
                'prescription_date' => '2024-08-10',
                'start_date' => '2024-08-11',
                'end_date' => '2024-11-11',
                'notes' => 'Take with food to improve absorption.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Patricia Moore',
                'name' => 'Vitamin D3',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Osteoporosis',
                'prescription_date' => '2024-08-10',
                'start_date' => '2024-08-11',
                'end_date' => '2024-11-11',
                'notes' => 'Essential for calcium absorption.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'James Taylor',
                'name' => 'Carbidopa-Levodopa',
                'instructions' => 't.i.d',
                'quantity' => 90,
                'diagnosis' => 'Parkinson\'s Disease',
                'prescription_date' => '2024-07-20',
                'start_date' => '2024-07-21',
                'end_date' => '2024-10-21',
                'notes' => 'Take 30 minutes before meals for best effect.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'James Taylor',
                'name' => 'Pramipexole',
                'instructions' => 't.i.d',
                'quantity' => 90,
                'diagnosis' => 'Parkinson\'s Disease',
                'prescription_date' => '2024-07-20',
                'start_date' => '2024-07-21',
                'end_date' => '2024-10-21',
                'notes' => 'May cause sleepiness, monitor for drowsiness.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Linda Anderson',
                'name' => 'Simvastatin',
                'instructions' => 'h.s',
                'quantity' => 30,
                'diagnosis' => 'High Cholesterol',
                'prescription_date' => '2024-09-05',
                'start_date' => '2024-09-06',
                'end_date' => '2024-12-06',
                'notes' => 'Take with evening meal.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Linda Anderson',
                'name' => 'Multivitamin',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'General Health',
                'prescription_date' => '2024-09-05',
                'start_date' => '2024-09-06',
                'end_date' => '2024-12-06',
                'notes' => 'Daily vitamin supplement.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Charles Thomas',
                'name' => 'Eye Drops',
                'instructions' => 'b.i.d',
                'quantity' => 30,
                'diagnosis' => 'Vision Impairment',
                'prescription_date' => '2024-08-15',
                'start_date' => '2024-08-16',
                'end_date' => '2024-11-16',
                'notes' => 'Apply to both eyes morning and evening.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Barbara Jackson',
                'name' => 'Loratadine',
                'instructions' => 'a.m',
                'quantity' => 30,
                'diagnosis' => 'Allergies (Pollen)',
                'prescription_date' => '2024-09-01',
                'start_date' => '2024-09-02',
                'end_date' => '2024-12-02',
                'notes' => 'Take during allergy season, may cause drowsiness.',
                'is_active' => true,
            ],
            [
                'resident_name' => 'Daniel White',
                'name' => 'Hearing Aid Batteries',
                'instructions' => 'PRN',
                'quantity' => 24,
                'diagnosis' => 'Hearing Loss',
                'prescription_date' => '2024-08-01',
                'start_date' => '2024-08-02',
                'end_date' => '2025-02-02',
                'notes' => 'Replace batteries as needed, typically weekly.',
                'is_active' => true,
            ],
        ];

        foreach ($medicationsData as $data) {
            $resident = $residents->where('name', $data['resident_name'])->first();
            
            if ($resident) {
                Medication::create([
                    'resident_id' => $resident->id,
                    'branch_id' => $resident->branch_id, // Add missing branch_id
                    'drug_id' => null, // Add missing drug_id (nullable)
                    'name' => $data['name'],
                    'instructions' => $data['instructions'],
                    'quantity' => $data['quantity'],
                    'diagnosis' => $data['diagnosis'],
                    'prescription_date' => Carbon::parse($data['prescription_date']),
                    'start_date' => Carbon::parse($data['start_date']),
                    'end_date' => Carbon::parse($data['end_date']),
                    'notes' => $data['notes'],
                    'is_active' => $data['is_active'],
                    'time_1' => '08:00:00', // Add missing time columns
                    'time_2' => '20:00:00',
                    'time_3' => null,
                    'time_4' => null,
                    'created_by' => $admin->id,
                ]);
            }
        }

        $this->command->info('Medications seeded successfully!');
    }
}
