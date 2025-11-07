<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Resident;
use App\Models\Branch;
use App\Models\AppointmentType;
use App\Models\HealthcareProvider;
use App\Models\User;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
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

        // Get appointment types
        $clinicianType = AppointmentType::where('name', 'Clinician')->first();
        $counsellorType = AppointmentType::where('name', 'Counsellor')->first();
        $primaryCareType = AppointmentType::where('name', 'Primary Care Provider (DCPA)')->first();
        $otherType = AppointmentType::where('name', 'Other')->first();
        $specialistType = AppointmentType::where('name', 'Specialist')->first();
        $dentalType = AppointmentType::where('name', 'Dental')->first();
        $visionType = AppointmentType::where('name', 'Vision')->first();
        $therapyType = AppointmentType::where('name', 'Therapy')->first();

        // Get branches
        $bothellBranch = Branch::where('name', 'like', '%Bothell%')->first();
        $edmondsBranch = Branch::where('name', 'like', '%Edmonds%')->first();
        $canyonParkBranch = Branch::where('name', 'like', '%Canyon Park%')->first();
        $harbourPointeBranch = Branch::where('name', 'like', '%Harbour Pointe%')->first();

        // Get residents (or create some if they don't exist)
        $residents = Resident::where('is_active', true)->get();
        if ($residents->isEmpty()) {
            $this->command->error('No active residents found. Creating sample residents...');
            $this->createSampleResidents($bothellBranch, $edmondsBranch);
            $residents = Resident::where('is_active', true)->get();
        }

        // Create healthcare providers if they don't exist
        $this->createHealthcareProviders();

        $wyattProvider = HealthcareProvider::where('name', 'like', '%Wyatt%')->first();
        $dentalProvider = HealthcareProvider::where('name', 'like', '%Dental%')->first();
        $visionProvider = HealthcareProvider::where('name', 'like', '%Vision%')->first();

        // Sample appointments based on your example data
        $appointments = [
            // Angasa Wanjalatan appointments (Bothell Serenity AFH)
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $otherType,
                'appointment_date' => Carbon::create(2025, 3, 3),
                'appointment_time' => Carbon::createFromTime(9, 0),
                'provider_name' => 'Injection Nurse',
                'location' => 'in-house',
                'description' => 'Invega shot',
                'status' => 'completed',
                'next_appointment_date' => Carbon::create(2025, 3, 24),
                'recurrence_pattern' => 'monthly',
                'notes' => 'Monthly injection - resident responded well',
            ],
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $otherType,
                'appointment_date' => Carbon::create(2025, 3, 14),
                'appointment_time' => Carbon::createFromTime(10, 30),
                'provider_name' => 'Injection Nurse',
                'location' => 'in-house',
                'description' => 'Haldol injection (Every 28 days)',
                'status' => 'completed',
                'next_appointment_date' => Carbon::create(2025, 4, 11),
                'recurrence_pattern' => 'custom',
                'notes' => 'Every 28 days - no side effects observed',
            ],
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $clinicianType,
                'appointment_date' => Carbon::create(2025, 3, 20),
                'appointment_time' => Carbon::createFromTime(13, 0),
                'provider_name' => 'Wyatt',
                'healthcare_provider' => $wyattProvider,
                'location' => 'in-house',
                'description' => 'Wyatt @ 1 p.m',
                'status' => 'completed',
                'next_appointment_date' => Carbon::create(2025, 3, 27),
                'recurrence_pattern' => 'weekly',
                'notes' => 'Regular checkup - resident stable',
            ],
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $counsellorType,
                'appointment_date' => Carbon::create(2025, 4, 10),
                'appointment_time' => Carbon::createFromTime(13, 0),
                'provider_name' => 'Wyatt',
                'healthcare_provider' => $wyattProvider,
                'location' => 'in-house',
                'description' => 'Wyatt in house call at 1 p.m',
                'status' => 'scheduled',
                'next_appointment_date' => Carbon::create(2025, 4, 17),
                'recurrence_pattern' => 'weekly',
                'notes' => 'Counseling session scheduled',
            ],
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $counsellorType,
                'appointment_date' => Carbon::create(2025, 5, 8),
                'appointment_time' => Carbon::createFromTime(13, 0),
                'provider_name' => 'Wyatt',
                'healthcare_provider' => $wyattProvider,
                'location' => 'in-house',
                'description' => 'wyatt @ 1 p.m',
                'status' => 'scheduled',
                'next_appointment_date' => Carbon::create(2025, 5, 15),
                'recurrence_pattern' => 'weekly',
                'notes' => 'Follow-up counseling session',
            ],
            [
                'resident_name' => 'Angasa Wanjalatan',
                'branch' => $bothellBranch,
                'appointment_type' => $primaryCareType,
                'appointment_date' => Carbon::create(2025, 6, 17),
                'appointment_time' => Carbon::createFromTime(10, 45),
                'provider_name' => 'Dr. Smith (DCPA)',
                'location' => 'external',
                'description' => '@10:45 a.m. - 12:45 p.m',
                'status' => 'scheduled',
                'next_appointment_date' => Carbon::create(2025, 6, 17),
                'recurrence_pattern' => 'one-time',
                'notes' => 'Annual physical examination',
            ],
        ];

        // Create additional sample appointments for other residents
        $additionalAppointments = $this->generateAdditionalAppointments($residents, $user);

        $allAppointments = array_merge($appointments, $additionalAppointments);

        foreach ($allAppointments as $appointmentData) {
            // Find or create resident
            $resident = null;
            if (isset($appointmentData['resident_name'])) {
                $resident = Resident::where('name', $appointmentData['resident_name'])->first();
                if (!$resident && $appointmentData['branch']) {
                    // Create the resident if it doesn't exist
                    $firstName = explode(' ', $appointmentData['resident_name'])[0];
                    $gender = $this->guessGender($firstName);
                    
                    $resident = Resident::create([
                        'name' => $appointmentData['resident_name'],
                        'first_name' => $firstName,
                        'last_name' => explode(' ', $appointmentData['resident_name'])[1] ?? '',
                        'branch_id' => $appointmentData['branch']->id,
                        'is_active' => true,
                        'date_of_birth' => Carbon::now()->subYears(rand(65, 95)),
                        'admission_date' => Carbon::now()->subMonths(rand(1, 24)),
                        'diagnosis' => 'General care',
                        'gender' => $gender,
                    ]);
                }
            } else {
                $resident = $appointmentData['resident'];
            }

            if ($resident) {
                Appointment::create([
                    'resident_id' => $resident->id,
                    'branch_id' => $appointmentData['branch']->id,
                    'title' => $appointmentData['provider_name'] . ' - ' . $appointmentData['description'], // Add missing title
                    'description' => $appointmentData['description'],
                    'appointment_date' => $appointmentData['appointment_date'], // Use datetime format
                    'location' => $appointmentData['location'],
                    'provider_name' => $appointmentData['provider_name'],
                    'provider_phone' => '555-0123', // Add missing provider_phone
                    'status' => $appointmentData['status'],
                    'notes' => $appointmentData['notes'],
                    'created_by' => $user->id,
                ]);
            }
        }

        $this->command->info('Created ' . count($allAppointments) . ' sample appointments.');
    }

    private function createSampleResidents($bothellBranch, $edmondsBranch)
    {
        $sampleResidents = [
            ['name' => 'Angasa Wanjalatan', 'branch' => $bothellBranch, 'gender' => 'Male'],
            ['name' => 'John Smith', 'branch' => $edmondsBranch, 'gender' => 'Male'],
            ['name' => 'Mary Johnson', 'branch' => $bothellBranch, 'gender' => 'Female'],
            ['name' => 'Robert Davis', 'branch' => $edmondsBranch, 'gender' => 'Male'],
            ['name' => 'Sarah Wilson', 'branch' => $bothellBranch, 'gender' => 'Female'],
        ];

        foreach ($sampleResidents as $residentData) {
            if ($residentData['branch']) {
                $firstName = explode(' ', $residentData['name'])[0];
                $gender = $residentData['gender'] ?? $this->guessGender($firstName);
                
                Resident::create([
                    'name' => $residentData['name'],
                    'first_name' => $firstName,
                    'last_name' => explode(' ', $residentData['name'])[1] ?? '',
                    'branch_id' => $residentData['branch']->id,
                    'is_active' => true,
                    'date_of_birth' => Carbon::now()->subYears(rand(65, 95)),
                    'admission_date' => Carbon::now()->subMonths(rand(1, 24)),
                    'diagnosis' => 'General care',
                    'gender' => $gender,
                ]);
            }
        }
    }

    /**
     * Guess gender from common first names (simple heuristic)
     */
    private function guessGender(string $firstName): string
    {
        $femaleNames = ['Mary', 'Patricia', 'Linda', 'Barbara', 'Elizabeth', 'Jennifer', 'Maria', 'Susan', 'Sarah', 'Jessica', 'Emily', 'Ashley', 'Amanda', 'Melissa', 'Deborah', 'Stephanie', 'Rebecca', 'Sharon', 'Michelle', 'Laura', 'Kimberly', 'Amy', 'Angela', 'Brenda', 'Emma', 'Olivia', 'Sophia', 'Isabella', 'Mia', 'Charlotte'];
        
        return in_array($firstName, $femaleNames) ? 'Female' : 'Male';
    }

    private function createHealthcareProviders()
    {
        $providers = [
            ['name' => 'Dr. Wyatt Thompson', 'specialty' => 'General Medicine', 'phone' => '(555) 123-4567'],
            ['name' => 'Dr. Sarah Martinez', 'specialty' => 'Dentistry', 'phone' => '(555) 234-5678'],
            ['name' => 'Dr. Michael Chen', 'specialty' => 'Ophthalmology', 'phone' => '(555) 345-6789'],
            ['name' => 'Dr. Lisa Rodriguez', 'specialty' => 'Physical Therapy', 'phone' => '(555) 456-7890'],
            ['name' => 'Dr. James Wilson', 'specialty' => 'Cardiology', 'phone' => '(555) 567-8901'],
            ['name' => 'Nurse Practitioner Amy Brown', 'specialty' => 'Primary Care', 'phone' => '(555) 678-9012'],
        ];

        foreach ($providers as $providerData) {
            HealthcareProvider::firstOrCreate(
                ['name' => $providerData['name']],
                $providerData
            );
        }
    }

    private function generateAdditionalAppointments($residents, $user)
    {
        $appointmentTypes = AppointmentType::all();
        $branches = Branch::where('is_active', true)->get();
        $providers = HealthcareProvider::all();

        $appointments = [];

        // Generate past completed appointments (last 60 days)
        for ($i = 0; $i < 30; $i++) {
            $resident = $residents->random();
            $branch = $branches->random();
            $appointmentType = $appointmentTypes->random();
            $provider = $providers->random();

            $appointmentDate = Carbon::now()->subDays(rand(1, 60));
            $appointmentTime = Carbon::createFromTime(rand(8, 16), rand(0, 59));

            $locations = ['in-house', 'external', 'telehealth'];
            $completionNotes = [
                'Appointment completed successfully. Resident responded well to treatment.',
                'Follow-up appointment completed. No concerns noted.',
                'Regular checkup completed. Vital signs stable.',
                'Treatment administered as scheduled. No adverse reactions.',
                'Consultation completed. Treatment plan reviewed and updated.',
                'Appointment completed on time. Resident in good spirits.',
                'Follow-up completed. Progress noted in treatment.',
                'Routine appointment completed without issues.',
            ];

            $appointments[] = [
                'resident' => $resident,
                'branch' => $branch,
                'appointment_type' => $appointmentType,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'provider_name' => $provider->name,
                'healthcare_provider' => $provider,
                'location' => $locations[array_rand($locations)],
                'description' => 'Regular appointment for ' . $appointmentType->name,
                'status' => 'completed',
                'next_appointment_date' => rand(0, 1) ? $appointmentDate->copy()->addDays(rand(7, 30)) : null,
                'recurrence_pattern' => ['one-time', 'weekly', 'monthly', 'custom'][array_rand(['one-time', 'weekly', 'monthly', 'custom'])],
                'notes' => $completionNotes[array_rand($completionNotes)],
            ];
        }

        // Generate upcoming scheduled appointments (next 30 days)
        for ($i = 0; $i < 25; $i++) {
            $resident = $residents->random();
            $branch = $branches->random();
            $appointmentType = $appointmentTypes->random();
            $provider = $providers->random();

            $appointmentDate = Carbon::now()->addDays(rand(1, 30));
            $appointmentTime = Carbon::createFromTime(rand(8, 16), rand(0, 59));

            $statuses = ['scheduled', 'confirmed'];
            $locations = ['in-house', 'external', 'telehealth'];
            $patterns = ['one-time', 'weekly', 'monthly', 'custom'];

            $appointments[] = [
                'resident' => $resident,
                'branch' => $branch,
                'appointment_type' => $appointmentType,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'provider_name' => $provider->name,
                'healthcare_provider' => $provider,
                'location' => $locations[array_rand($locations)],
                'description' => 'Regular appointment for ' . $appointmentType->name,
                'status' => $statuses[array_rand($statuses)],
                'next_appointment_date' => rand(0, 1) ? $appointmentDate->copy()->addDays(rand(7, 30)) : null,
                'recurrence_pattern' => $patterns[array_rand($patterns)],
                'notes' => 'Scheduled appointment - awaiting completion',
            ];
        }

        // Generate some in-progress appointments (today)
        for ($i = 0; $i < 5; $i++) {
            $resident = $residents->random();
            $branch = $branches->random();
            $appointmentType = $appointmentTypes->random();
            $provider = $providers->random();

            $appointmentDate = Carbon::today();
            $appointmentTime = Carbon::createFromTime(rand(8, 16), rand(0, 59));

            $locations = ['in-house', 'external', 'telehealth'];

            $appointments[] = [
                'resident' => $resident,
                'branch' => $branch,
                'appointment_type' => $appointmentType,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'provider_name' => $provider->name,
                'healthcare_provider' => $provider,
                'location' => $locations[array_rand($locations)],
                'description' => 'Regular appointment for ' . $appointmentType->name,
                'status' => 'in_progress',
                'next_appointment_date' => rand(0, 1) ? $appointmentDate->copy()->addDays(rand(7, 30)) : null,
                'recurrence_pattern' => ['one-time', 'weekly', 'monthly', 'custom'][array_rand(['one-time', 'weekly', 'monthly', 'custom'])],
                'notes' => 'Appointment in progress',
            ];
        }

        return $appointments;
    }
}
