<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\VitalSign;

class VitalTrendsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Vital Signs Trends';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $vitalSigns = VitalSign::whereBetween('measurement_date', [$weekStart, $weekEnd])
            ->orderBy('measurement_date')
            ->get();
        
        $vitalSignsByDay = $vitalSigns->groupBy(function($item) {
            return $item->measurement_date->format('Y-m-d');
        });
        
        $labels = [];
        $systolicData = [];
        $diastolicData = [];
        $pulseData = [];
        $temperatureData = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('M j');
            
            $dayVitals = $vitalSignsByDay->get($dateStr, collect());
            
            $systolicData[] = $dayVitals->avg('systolic') ?? 0;
            $diastolicData[] = $dayVitals->avg('diastolic') ?? 0;
            $pulseData[] = $dayVitals->avg('pulse') ?? 0;
            $temperatureData[] = $dayVitals->avg('temperature') ?? 0;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Systolic',
                    'data' => $systolicData,
                    'borderColor' => '#EF4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
                [
                    'label' => 'Diastolic',
                    'data' => $diastolicData,
                    'borderColor' => '#F97316',
                    'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
                [
                    'label' => 'Pulse',
                    'data' => $pulseData,
                    'borderColor' => '#8B5CF6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
                [
                    'label' => 'Temperature',
                    'data' => $temperatureData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.3,
                    'fill' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
