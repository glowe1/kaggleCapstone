<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Resident;
use App\Models\Branch;
use App\Models\VitalSign;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ResidentCharts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.resident-charts';
    protected static ?string $title = 'Resident Analytics';
    protected static ?string $navigationLabel = 'Resident Charts';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public function getResidentStats(): array
    {
        $totalResidents = Resident::count();
        $residentsByBranch = Resident::with('branch')
            ->get()
            ->groupBy('branch.name')
            ->map->count();

        // Calculate age groups using PHP instead of SQL
        $residents = Resident::whereNotNull('date_of_birth')->get();
        $ageGroups = [
            'Under 18' => 0,
            '18-30' => 0,
            '31-50' => 0,
            '51-70' => 0,
            'Over 70' => 0,
            'Unknown' => 0,
        ];

        foreach ($residents as $resident) {
            if (!$resident->date_of_birth) {
                $ageGroups['Unknown']++;
                continue;
            }

            $age = $resident->date_of_birth->diffInYears(Carbon::now());
            
            if ($age < 18) {
                $ageGroups['Under 18']++;
            } elseif ($age <= 30) {
                $ageGroups['18-30']++;
            } elseif ($age <= 50) {
                $ageGroups['31-50']++;
            } elseif ($age <= 70) {
                $ageGroups['51-70']++;
            } else {
                $ageGroups['Over 70']++;
            }
        }

        $residentsByAge = collect($ageGroups);

        $recentResidents = Resident::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        return [
            'total_residents' => $totalResidents,
            'residents_by_branch' => $residentsByBranch,
            'residents_by_age' => $residentsByAge,
            'recent_residents' => $recentResidents,
        ];
    }

    public function getHealthStatusData(): array
    {
        $residents = Resident::with(['vitalSigns' => function($query) {
            $query->latest('measurement_date')->limit(1);
        }])->get();

        $healthStatus = [
            'excellent' => 0,
            'good' => 0,
            'fair' => 0,
            'poor' => 0,
            'unknown' => 0,
        ];

        foreach ($residents as $resident) {
            $latestVitals = $resident->vitalSigns->first();
            
            if (!$latestVitals) {
                $healthStatus['unknown']++;
                continue;
            }

            if ($latestVitals->systolic <= 120 && $latestVitals->diastolic <= 80 && 
                $latestVitals->pulse >= 60 && $latestVitals->pulse <= 100) {
                $healthStatus['excellent']++;
            } elseif ($latestVitals->systolic <= 140 && $latestVitals->diastolic <= 90) {
                $healthStatus['good']++;
            } elseif ($latestVitals->systolic <= 160 && $latestVitals->diastolic <= 100) {
                $healthStatus['fair']++;
            } else {
                $healthStatus['poor']++;
            }
        }

        return [
            'labels' => ['Excellent', 'Good', 'Fair', 'Poor', 'Unknown'],
            'data' => array_values($healthStatus),
            'colors' => ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#6B7280'],
        ];
    }

    public function getResidentTrends(): array
    {
        $last30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Resident::whereDate('created_at', $date)->count();
            $last30Days[] = [
                'date' => $date->format('M j'),
                'count' => $count
            ];
        }

        return $last30Days;
    }
}
