<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Resident;
use App\Models\VitalSign;
use App\Models\Assessment;
use Carbon\Carbon;

class CaregiverDataVisualizationWidget extends Widget
{
    protected static string $view = 'filament.widgets.caregiver-data-visualization-widget';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function getChartData(): array
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();
        
        // Get assigned residents
        $assignedResidents = Resident::whereHas('assignments', function($query) use ($userId) {
            $query->where('caregiver_id', $userId)->where('is_active', true);
        })->get();
        
        $residentIds = $assignedResidents->pluck('id');
        
        // Vital signs data for the week
        $vitalSigns = VitalSign::whereIn('resident_id', $residentIds)
            ->whereBetween('measurement_date', [$weekStart, $weekEnd])
            ->orderBy('measurement_date')
            ->get();
        
        // Group by day
        $vitalSignsByDay = $vitalSigns->groupBy(function($item) {
            return $item->measurement_date->format('Y-m-d');
        });
        
        // Create chart data
        $chartData = [];
        $labels = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('M j');
            
            $dayVitals = $vitalSignsByDay->get($dateStr, collect());
            $chartData[] = $dayVitals->count();
        }
        
        // Assessment completion data
        $assessments = Assessment::whereIn('resident_id', $residentIds)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get();
        
        $assessmentData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            
            $dayAssessments = $assessments->filter(function($item) use ($dateStr) {
                return $item->created_at->format('Y-m-d') === $dateStr;
            });
            
            $assessmentData[] = $dayAssessments->count();
        }
        
        // Resident health status
        $residentHealthStatus = [];
        foreach ($assignedResidents as $resident) {
            $latestVitals = VitalSign::where('resident_id', $resident->id)
                ->orderBy('measurement_date', 'desc')
                ->first();
            
            $status = 'good';
            if ($latestVitals) {
                // Simple health status logic
                if ($latestVitals->systolic > 140 || 
                    $latestVitals->diastolic > 90 ||
                    $latestVitals->pulse > 100) {
                    $status = 'attention';
                } elseif ($latestVitals->systolic < 90 || 
                         $latestVitals->diastolic < 60 ||
                         $latestVitals->pulse < 50) {
                    $status = 'caution';
                }
            }
            
            $residentHealthStatus[] = [
                'name' => $resident->name,
                'status' => $status,
                'last_vitals' => $latestVitals ? $latestVitals->measurement_date->diffForHumans() : 'No recent data'
            ];
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Vital Signs',
                    'data' => $chartData,
                    'borderColor' => '#3B82F6', // blue-500
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
                [
                    'label' => 'Assessments',
                    'data' => $assessmentData,
                    'borderColor' => '#10B981', // emerald-500
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
            ],
            'residentHealthStatus' => $residentHealthStatus,
        ];
    }
}
