<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Facility;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

/**
 * Creates facility admin users for each facility
 * Each facility gets an administrator account
 */
class FacilityAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👥 Creating facility admin users...');

        // Use withoutGlobalScopes to ensure we see all facilities during seeding
        $facilities = Facility::withoutGlobalScopes()->where('is_active', true)->get();

        if ($facilities->isEmpty()) {
            $this->command->warn('No active facilities found. Please run FacilitySeeder first.');
            return;
        }

        $created = 0;
        $updated = 0;

        foreach ($facilities as $facility) {
            // Get the first active branch for this facility (without global scopes for seeding)
            $branch = Branch::withoutGlobalScopes()
                ->where('facility_id', $facility->id)
                ->where('is_active', true)
                ->first();

            if (!$branch) {
                $this->command->warn("No active branch found for facility: {$facility->name}. Skipping admin creation.");
                continue;
            }

            // Generate email from facility name (sanitize)
            $facilitySlug = strtolower(preg_replace('/[^a-z0-9]+/i', '', $facility->name));
            $email = "admin@{$facilitySlug}.com";

            // Ensure unique email
            $counter = 1;
            $originalEmail = $email;
            while (User::where('email', $email)->exists()) {
                $email = str_replace('@', "{$counter}@", $originalEmail);
                $counter++;
            }

            // Create or update facility admin
            $adminUser = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "{$facility->name} Administrator",
                    'email' => $email,
                    'password' => Hash::make('password'), // Change in production!
                    'role' => 'administrator',
                    'facility_id' => $facility->id,
                    'assigned_branch_id' => $branch->id,
                    'is_active' => true,
                ]
            );

            if ($adminUser->wasRecentlyCreated) {
                $created++;
                $this->command->line("  ✅ Created admin for: {$facility->name} ({$email})");
            } else {
                // Update existing user to ensure facility and branch are set
                $updated++;
                $adminUser->update([
                    'facility_id' => $facility->id,
                    'assigned_branch_id' => $branch->id,
                ]);
                $this->command->line("  🔄 Updated admin for: {$facility->name} ({$email})");
            }
        }

        $this->command->info("✅ Created {$created} facility admin(s), updated {$updated} existing admin(s)");
        $this->command->warn('⚠️  Default password for all facility admins: password - Change this in production!');
    }
}

