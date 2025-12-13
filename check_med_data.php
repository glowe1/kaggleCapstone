<?php

use App\Models\MedicationAdministration;
use App\Models\User;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Get the user
$user = User::where('email', 'admin@edmondserenity.com')->first();
if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Facility ID: {$user->facility_id}\n";

// 2. Check for ANY records for this facility
$count = MedicationAdministration::whereHas('branch', function ($q) use ($user) {
    $q->where('facility_id', $user->facility_id);
})->count();

echo "Total records for facility {$user->facility_id}: {$count}\n";

// 3. Check for records in the last 7 days
$startDate = Carbon::create(2025, 12, 6)->startOfDay();
$endDate = Carbon::create(2025, 12, 13)->endOfDay();

echo "Checking range: {$startDate} to {$endDate}\n";

$recentCount = MedicationAdministration::whereHas('branch', function ($q) use ($user) {
    $q->where('facility_id', $user->facility_id);
})
->whereBetween('administered_at', [$startDate, $endDate])
->count();

echo "Records in range: {$recentCount}\n";

// 4. Dump a few recent records to check statuses and dates
if ($recentCount > 0) {
    $records = MedicationAdministration::whereHas('branch', function ($q) use ($user) {
        $q->where('facility_id', $user->facility_id);
    })
    ->whereBetween('administered_at', [$startDate, $endDate])
    ->limit(5)
    ->get();

    foreach ($records as $r) {
        echo "ID: {$r->id} | Status: {$r->status} | Date: {$r->administered_at}\n";
    }
} else {
    // Check if there are ANY records recently, ignoring facility scope
    $anyRecent = MedicationAdministration::whereBetween('administered_at', [$startDate, $endDate])->count();
    echo "Records in range (ignoring facility): {$anyRecent}\n";
}
