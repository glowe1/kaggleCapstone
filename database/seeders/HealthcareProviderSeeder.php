<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthcareProvider;
use App\Models\Branch;

class HealthcareProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        if ($branches->isEmpty()) {
            $this->command->warn('No branches found. Please run BranchSeeder first.');
            return;
        }

        $specialties = [
            'Internal Medicine',
            'Geriatrics',
            'Cardiology',
            'Neurology',
            'Psychiatry',
            'Orthopedics',
            'Dermatology',
            'Ophthalmology',
            'Dentistry',
            'Physical Therapy',
            'Occupational Therapy',
            'Speech Therapy',
            'Nursing',
            'Social Work',
            'Nutrition'
        ];

        $providerTypes = [
            'Doctor',
            'Nurse Practitioner',
            'Physician Assistant',
            'Registered Nurse',
            'Licensed Practical Nurse',
            'Physical Therapist',
            'Occupational Therapist',
            'Speech Therapist',
            'Social Worker',
            'Dietitian',
            'Pharmacist',
            'Dentist',
            'Psychologist',
            'Counselor',
            'Specialist'
        ];

        $firstNames = [
            'Dr. Sarah', 'Dr. Michael', 'Dr. Jennifer', 'Dr. David', 'Dr. Lisa',
            'Dr. Robert', 'Dr. Maria', 'Dr. James', 'Dr. Patricia', 'Dr. John',
            'Dr. Elizabeth', 'Dr. William', 'Dr. Susan', 'Dr. Richard', 'Dr. Nancy',
            'Dr. Thomas', 'Dr. Karen', 'Dr. Christopher', 'Dr. Barbara', 'Dr. Daniel'
        ];

        $lastNames = [
            'Johnson', 'Smith', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller',
            'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez',
            'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'
        ];

        foreach ($branches as $branch) {
            // Create 5-10 healthcare providers per branch
            $providerCount = rand(5, 10);
            
            for ($i = 0; $i < $providerCount; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $specialty = $specialties[array_rand($specialties)];
                $providerType = $providerTypes[array_rand($providerTypes)];
                
                HealthcareProvider::create([
                    'name' => $firstName . ' ' . $lastName,
                    'specialty' => $specialty,
                    'phone' => $this->generatePhoneNumber(),
                    'email' => strtolower($firstName . '.' . $lastName . '@healthcare.com'),
                    'contact_info' => $this->generateContactInfo(),
                    'is_active' => rand(0, 1) == 1,
                    'notes' => $this->generateProviderNotes($specialty),
                ]);
            }
        }

        $this->command->info('HealthcareProviderSeeder completed successfully!');
    }

    private function generateContactInfo(): string
    {
        $address = $this->generateAddress();
        $city = $this->generateCity();
        $state = $this->generateState();
        $zipCode = $this->generateZipCode();
        
        return "Address: {$address}, {$city}, {$state} {$zipCode}";
    }

    private function generatePhoneNumber(): string
    {
        $areaCode = rand(200, 999);
        $exchange = rand(200, 999);
        $number = rand(1000, 9999);
        return "($areaCode) $exchange-$number";
    }

    private function generateAddress(): string
    {
        $streetNumbers = ['123', '456', '789', '321', '654', '987', '147', '258', '369', '741'];
        $streetNames = [
            'Main St', 'Oak Ave', 'Pine St', 'Cedar Blvd', 'Elm Dr', 'Maple Ave',
            'First St', 'Second Ave', 'Park Rd', 'Garden St', 'Health Dr', 'Medical Blvd'
        ];
        
        $number = $streetNumbers[array_rand($streetNumbers)];
        $street = $streetNames[array_rand($streetNames)];
        return $number . ' ' . $street;
    }

    private function generateCity(): string
    {
        $cities = [
            'Springfield', 'Franklin', 'Georgetown', 'Clinton', 'Madison', 'Washington',
            'Jefferson', 'Jackson', 'Lincoln', 'Roosevelt', 'Kennedy', 'Reagan',
            'Bush', 'Clinton', 'Obama', 'Trump', 'Biden', 'Adams', 'Monroe', 'Harrison'
        ];
        
        return $cities[array_rand($cities)];
    }

    private function generateState(): string
    {
        $states = [
            'CA', 'NY', 'TX', 'FL', 'IL', 'PA', 'OH', 'GA', 'NC', 'MI',
            'NJ', 'VA', 'WA', 'AZ', 'MA', 'TN', 'IN', 'MO', 'MD', 'WI'
        ];
        
        return $states[array_rand($states)];
    }

    private function generateZipCode(): string
    {
        return str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
    }

    private function generateProviderNotes(string $specialty): string
    {
        $notes = [
            'Internal Medicine' => 'Board-certified internal medicine physician with extensive experience in geriatric care.',
            'Geriatrics' => 'Specialized in geriatric medicine with focus on age-related health conditions.',
            'Cardiology' => 'Cardiologist with expertise in heart disease management for elderly patients.',
            'Neurology' => 'Neurologist specializing in dementia and neurological disorders in seniors.',
            'Psychiatry' => 'Geriatric psychiatrist with experience in mental health care for elderly.',
            'Orthopedics' => 'Orthopedic specialist focusing on bone and joint health in aging patients.',
            'Dermatology' => 'Dermatologist with expertise in skin conditions common in elderly patients.',
            'Ophthalmology' => 'Eye care specialist providing comprehensive vision care for seniors.',
            'Dentistry' => 'Dentist specializing in oral health care for elderly patients.',
            'Physical Therapy' => 'Licensed physical therapist with expertise in geriatric rehabilitation.',
            'Occupational Therapy' => 'Occupational therapist specializing in daily living skills for seniors.',
            'Speech Therapy' => 'Speech-language pathologist with experience in communication disorders.',
            'Nursing' => 'Registered nurse with specialized training in geriatric nursing care.',
            'Social Work' => 'Licensed social worker providing support services for elderly and families.',
            'Nutrition' => 'Registered dietitian specializing in nutritional needs of elderly patients.'
        ];

        return $notes[$specialty] ?? 'Healthcare provider with expertise in patient care.';
    }
}
