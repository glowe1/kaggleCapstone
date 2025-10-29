<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\VitalSign;

class VitalTrendsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Vital Signs Trends';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        try {
            $weekStart = now()->startOfWeek();
            $weekEnd = now()->endOfWeek();
            
            $vitalSigns = VitalSign::whereBetween('measurement_date', [$weekStart, $weekEnd])
                ->orderBy('measurement_date')
                ->get();
            
            $vitalSignsByDay = $vitalSigns->groupBy(function($item) {
                if (!$item->measurement_date) {
                    return null;
                }
                return $item->measurement_date instanceof \Carbon\Carbon 
                    ? $item->measurement_date->format('Y-m-d')
                    : \Carbon\Carbon::parse($item->measurement_date)->format('Y-m-d');
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
                
                $systolicData[] = $dayVitals->avg('systolic') ?? null;
                $diastolicData[] = $dayVitals->avg('diastolic') ?? null;
                $pulseData[] = $dayVitals->avg('pulse') ?? null;
                $temperatureData[] = $dayVitals->avg('temperature') ?? null;
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
        } catch (\Exception $e) {
            \Log::error('VitalTrendsChartWidget error: ' . $e->getMessage());
            // Return empty chart data
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }
    }

    protected function getType(): string
    {
        return 'line';
    }
}
