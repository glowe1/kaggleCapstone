<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\VitalSign;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VitalsCharts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.vitals-charts';
    protected static ?string $title = 'Vital Signs Analytics';
    protected static ?string $navigationLabel = 'Vitals Charts';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public function getVitalsStats(): array
    {
        $totalVitals = VitalSign::count();
        $todayVitals = VitalSign::whereDate('measurement_date', today())->count();
        $weekVitals = VitalSign::whereBetween('measurement_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthVitals = VitalSign::whereMonth('measurement_date', Carbon::now()->month)->count();

        return [
            'total_vitals' => $totalVitals,
            'today_vitals' => $todayVitals,
            'week_vitals' => $weekVitals,
            'month_vitals' => $monthVitals,
        ];
    }

    public function getVitalsTrends(): array
    {
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = VitalSign::whereDate('measurement_date', $date)->count();
            $last7Days[] = [
                'date' => $date->format('M j'),
                'count' => $count
            ];
        }

        return $last7Days;
    }

    public function getBloodPressureData(): array
    {
        $vitals = VitalSign::latest('measurement_date')->limit(100)->get();
        
        $systolicData = $vitals->pluck('systolic')->toArray();
        $diastolicData = $vitals->pluck('diastolic')->toArray();
        $labels = $vitals->map(function($vital) {
            return $vital->measurement_date->format('M j');
        })->toArray();

        return [
            'labels' => $labels,
            'systolic' => $systolicData,
            'diastolic' => $diastolicData,
        ];
    }

    public function getPulseData(): array
    {
        $vitals = VitalSign::latest('measurement_date')->limit(50)->get();
        
        $pulseData = $vitals->pluck('pulse')->toArray();
        $labels = $vitals->map(function($vital) {
            return $vital->measurement_date->format('M j');
        })->toArray();

        return [
            'labels' => $labels,
            'pulse' => $pulseData,
        ];
    }

    public function getVitalsByTimeOfDay(): array
    {
        $vitals = VitalSign::all();
        
        $timeSlots = [
            'morning' => 0,
            'afternoon' => 0,
            'evening' => 0,
            'night' => 0,
        ];

        foreach ($vitals as $vital) {
            $hour = $vital->measurement_date->hour;
            if ($hour >= 6 && $hour < 12) {
                $timeSlots['morning']++;
            } elseif ($hour >= 12 && $hour < 18) {
                $timeSlots['afternoon']++;
            } elseif ($hour >= 18 && $hour < 22) {
                $timeSlots['evening']++;
            } else {
                $timeSlots['night']++;
            }
        }

        return [
            'labels' => ['Morning (6-12)', 'Afternoon (12-18)', 'Evening (18-22)', 'Night (22-6)'],
            'data' => array_values($timeSlots),
            'colors' => ['#F59E0B', '#3B82F6', '#10B981', '#8B5CF6'],
        ];
    }
}
