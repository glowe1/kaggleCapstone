<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Branch;

class BranchChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Branch Performance';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        try {
            $branches = Branch::withCount(['residents', 'assignments'])->get();
            
            // Handle empty branches
            if ($branches->isEmpty()) {
                return [
                    'datasets' => [
                        [
                            'label' => 'Residents',
                            'data' => [],
                            'backgroundColor' => '#3B82F6',
                            'borderColor' => '#1D4ED8',
                            'borderWidth' => 2,
                        ],
                        [
                            'label' => 'Assignments',
                            'data' => [],
                            'backgroundColor' => '#10B981',
                            'borderColor' => '#059669',
                            'borderWidth' => 2,
                        ],
                    ],
                    'labels' => [],
                ];
            }
            
            return [
                'datasets' => [
                    [
                        'label' => 'Residents',
                        'data' => $branches->pluck('residents_count')->toArray(),
                        'backgroundColor' => '#3B82F6',
                        'borderColor' => '#1D4ED8',
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'Assignments',
                        'data' => $branches->pluck('assignments_count')->toArray(),
                        'backgroundColor' => '#10B981',
                        'borderColor' => '#059669',
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => $branches->pluck('name')->toArray(),
            ];
        } catch (\Exception $e) {
            \Log::error('BranchChartWidget error: ' . $e->getMessage());
            // Return empty chart data
            return [
                'datasets' => [
                    [
                        'label' => 'Residents',
                        'data' => [],
                        'backgroundColor' => '#3B82F6',
                        'borderColor' => '#1D4ED8',
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'Assignments',
                        'data' => [],
                        'backgroundColor' => '#10B981',
                        'borderColor' => '#059669',
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => [],
            ];
        }
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
