<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Facility;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first facility and its main branch
        $facility = Facility::first();
        $branch = $facility ? Branch::where('facility_id', $facility->id)->first() : null;

        if (!$facility || !$branch) {
            $this->command->warn('No facility or branch found. Please run FacilitySeeder and BranchSeeder first.');
            return;
        }

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@edmondserenity.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@edmondserenity.com',
                'password' => Hash::make('password'),
                'role' => 'administrator',
                'facility_id' => $facility->id,
                'assigned_branch_id' => $branch->id,
                'is_active' => true,
            ]
        );

        // Update existing user if it already exists but doesn't have facility/branch
        if (!$adminUser->wasRecentlyCreated) {
            $adminUser->update([
                'facility_id' => $facility->id,
                'assigned_branch_id' => $branch->id,
            ]);
        }

        $this->command->info('✅ Created/updated admin user with facility and branch assignment');
    }
}