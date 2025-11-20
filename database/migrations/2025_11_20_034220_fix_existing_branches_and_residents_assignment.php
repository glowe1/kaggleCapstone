<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Facility;
use App\Models\Branch;
use App\Models\Resident;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration fixes any existing branches and residents that might not have proper facility/branch assignments.
     * It assigns orphaned branches to a default facility and orphaned residents to branches within their facility.
     */
    public function up(): void
    {
        // Get or create default facility
        $defaultFacility = Facility::withoutGlobalScopes()->firstOrCreate(
            ['name' => 'Evergreen Oasis Care Home'],
            [
                'location' => 'Edmonds, WA',
                'description' => 'Our flagship facility providing compassionate care in a warm, home-like environment.',
                'address' => '123 Main Street, Edmonds, WA 98020',
                'phone' => '(206) 555-0123',
                'email' => 'info@evergreenoasis.com',
                'primary_color' => '#25603E',
                'secondary_color' => '#8B4513',
                'accent_color' => '#F5F5DC',
                'registration_status' => 'approved',
                'is_active' => true,
            ]
        );

        // Fix branches without facility_id
        $orphanedBranches = Branch::withoutGlobalScopes()->whereNull('facility_id')->get();
        if ($orphanedBranches->count() > 0) {
            DB::table('branches')
                ->whereNull('facility_id')
                ->update(['facility_id' => $defaultFacility->id]);
            
            echo "✅ Fixed {$orphanedBranches->count()} branches without facility_id\n";
        }

        // Fix residents without branch_id or with branch_id that doesn't belong to a facility
        $orphanedResidents = Resident::withoutGlobalScopes()
            ->where(function($query) {
                $query->whereNull('branch_id')
                      ->orWhereNotIn('branch_id', function($subQuery) {
                          $subQuery->select('id')
                                   ->from('branches')
                                   ->whereNotNull('facility_id');
                      });
            })
            ->get();

        if ($orphanedResidents->count() > 0) {
            // Get branches from the default facility
            $defaultBranches = Branch::withoutGlobalScopes()
                ->where('facility_id', $defaultFacility->id)
                ->active()
                ->get();

            if ($defaultBranches->isEmpty()) {
                // Create a default branch if none exists
                $defaultBranch = Branch::withoutGlobalScopes()->create([
                    'name' => 'Main Branch',
                    'address' => $defaultFacility->address,
                    'facility_id' => $defaultFacility->id,
                    'phone' => $defaultFacility->phone,
                    'email' => $defaultFacility->email,
                    'is_active' => true,
                ]);
                $defaultBranches = collect([$defaultBranch]);
            }

            // Assign orphaned residents to branches within the default facility
            $branchIndex = 0;
            foreach ($orphanedResidents as $resident) {
                $branch = $defaultBranches[$branchIndex % $defaultBranches->count()];
                
                DB::table('residents')
                    ->where('id', $resident->id)
                    ->update(['branch_id' => $branch->id]);
                
                $branchIndex++;
            }

            echo "✅ Fixed {$orphanedResidents->count()} residents without proper branch assignment\n";
        }

        // Verify all residents belong to branches within their facility
        // This handles edge cases where a resident's branch belongs to a different facility context
        $misassignedResidents = DB::select("
            SELECT r.id, r.name, r.branch_id, b.facility_id
            FROM residents r
            INNER JOIN branches b ON r.branch_id = b.id
            WHERE b.facility_id IS NULL OR b.facility_id = 0
        ");

        if (count($misassignedResidents) > 0) {
            $defaultBranches = Branch::withoutGlobalScopes()
                ->where('facility_id', $defaultFacility->id)
                ->active()
                ->pluck('id')
                ->toArray();

            if (!empty($defaultBranches)) {
                $branchIndex = 0;
                foreach ($misassignedResidents as $resident) {
                    $branchId = $defaultBranches[$branchIndex % count($defaultBranches)];
                    
                    DB::table('residents')
                        ->where('id', $resident->id)
                        ->update(['branch_id' => $branchId]);
                    
                    $branchIndex++;
                }

                echo "✅ Fixed " . count($misassignedResidents) . " residents with misassigned branches\n";
            }
        }

        echo "✅ Migration completed successfully!\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only fixes data, so there's nothing to reverse
        // The relationships should remain intact
    }
};
