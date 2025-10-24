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
        $branches = Branch::withCount(['residents', 'assignments'])->get();
        
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
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
