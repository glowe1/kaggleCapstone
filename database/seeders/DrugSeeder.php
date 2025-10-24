<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drug;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drugs = [
            [
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'description' => 'Pain reliever and fever reducer',
                'dosage_form' => 'tablet',
                'strength' => '500mg',
                'indications' => 'Pain relief, fever reduction',
                'contraindications' => 'Liver disease, alcohol abuse',
                'side_effects' => 'Nausea, rash, liver damage (rare)',
                'storage_instructions' => 'Store at room temperature, away from moisture',
                'is_active' => true,
            ],
            [
                'name' => 'Aspirin',
                'generic_name' => 'Acetylsalicylic acid',
                'description' => 'Anti-inflammatory and pain reliever',
                'dosage_form' => 'tablet',
                'strength' => '325mg',
                'indications' => 'Pain relief, anti-inflammatory, blood thinner',
                'contraindications' => 'Bleeding disorders, stomach ulcers, children under 12',
                'side_effects' => 'Stomach irritation, bleeding risk',
                'storage_instructions' => 'Store in cool, dry place',
                'is_active' => true,
            ],
            [
                'name' => 'Ibuprofen',
                'generic_name' => 'Ibuprofen',
                'description' => 'Non-steroidal anti-inflammatory drug (NSAID)',
                'dosage_form' => 'tablet',
                'strength' => '400mg',
                'indications' => 'Pain relief, inflammation reduction, fever',
                'contraindications' => 'Stomach ulcers, heart disease, kidney problems',
                'side_effects' => 'Stomach upset, dizziness, headache',
                'storage_instructions' => 'Store at room temperature',
                'is_active' => true,
            ],
            [
                'name' => 'Metformin',
                'generic_name' => 'Metformin hydrochloride',
                'description' => 'Antidiabetic medication',
                'dosage_form' => 'tablet',
                'strength' => '500mg',
                'indications' => 'Type 2 diabetes management',
                'contraindications' => 'Kidney disease, liver disease, heart failure',
                'side_effects' => 'Nausea, diarrhea, metallic taste',
                'storage_instructions' => 'Store at room temperature, protect from moisture',
                'is_active' => true,
            ],
            [
                'name' => 'Lisinopril',
                'generic_name' => 'Lisinopril',
                'description' => 'ACE inhibitor for blood pressure control',
                'dosage_form' => 'tablet',
                'strength' => '10mg',
                'indications' => 'High blood pressure, heart failure',
                'contraindications' => 'Pregnancy, kidney artery stenosis',
                'side_effects' => 'Dry cough, dizziness, fatigue',
                'storage_instructions' => 'Store at room temperature',
                'is_active' => true,
            ],
            [
                'name' => 'Atorvastatin',
                'generic_name' => 'Atorvastatin calcium',
                'description' => 'Statin for cholesterol management',
                'dosage_form' => 'tablet',
                'strength' => '20mg',
                'indications' => 'High cholesterol, cardiovascular protection',
                'contraindications' => 'Liver disease, pregnancy',
                'side_effects' => 'Muscle pain, liver enzyme elevation',
                'storage_instructions' => 'Store at room temperature',
                'is_active' => true,
            ],
        ];

        foreach ($drugs as $drug) {
            Drug::create($drug);
        }
    }
}
