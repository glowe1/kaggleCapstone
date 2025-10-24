<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core system seeders
            RolePermissionSeeder::class,
            FacilitySeeder::class,
            BranchSeeder::class,
            AdminUserSeeder::class,
            CaregiverSeeder::class,
            
            // Resident and care data
            ResidentSeeder::class,
            AssessmentSeeder::class,
            AssignmentSeeder::class,
            
            // Health and medical data
            VitalRangeSeeder::class,
            VitalSignSeeder::class,
            MedicationSeeder::class,
            MedicationAdministrationSeeder::class,
            AppointmentTypeSeeder::class,
            AppointmentSeeder::class,
            
            // Sleep monitoring
            SleepPatternSeeder::class,
            SleepRecordSeeder::class,
            SleepHourlyDataSeeder::class,
            
            // Behavior and incidents
            BehaviorCategorySeeder::class,
            BehaviorSeeder::class,
            IncidentSeeder::class,
            
            // Staff and documentation
            EmployeeDocumentSeeder::class,
            HealthcareProviderSeeder::class,
            LeaveRequestSeeder::class,
        ]);
    }
}
