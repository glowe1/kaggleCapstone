<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SleepHourlyData;
use App\Models\SleepRecord;
use Carbon\Carbon;

class SleepHourlyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sleepPatterns = \App\Models\SleepPattern::all();

        if ($sleepPatterns->isEmpty()) {
            $this->command->warn('No sleep patterns found. Please run SleepPatternSeeder first.');
            return;
        }

        foreach ($sleepPatterns as $sleepPattern) {
            // Generate hourly sleep data for each hour of the day (0-23)
            $hourlyData = [];
            for ($hour = 0; $hour < 24; $hour++) {
                $hourlyData['hour_' . str_pad($hour, 2, '0', STR_PAD_LEFT)] = $this->generateHourlySleepValue($hour);
            }
            
            SleepHourlyData::create([
                'sleep_pattern_id' => $sleepPattern->id,
                ...$hourlyData,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('SleepHourlyDataSeeder completed successfully!');
    }

    private function generateHourlySleepValue(int $hour): float
    {
        // Generate sleep activity value (0.0 to 1.0) based on hour of day
        // Higher values indicate more sleep activity
        
        if ($hour >= 22 || $hour <= 6) {
            // Night hours - higher sleep activity
            return round(rand(60, 95) / 100, 2);
        } elseif ($hour >= 7 && $hour <= 9) {
            // Morning hours - moderate sleep activity
            return round(rand(30, 70) / 100, 2);
        } elseif ($hour >= 10 && $hour <= 16) {
            // Day hours - lower sleep activity
            return round(rand(5, 30) / 100, 2);
        } else {
            // Evening hours - moderate sleep activity
            return round(rand(20, 60) / 100, 2);
        }
    }
}
