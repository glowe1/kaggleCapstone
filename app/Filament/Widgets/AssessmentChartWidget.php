<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Assessment;

class AssessmentChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Assessment Status';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $assessments = Assessment::all();
        
        $completed = $assessments->where('completion_percentage', 100)->count();
        $inProgress = $assessments->where('completion_percentage', '>', 0)->where('completion_percentage', '<', 100)->count();
        $notStarted = $assessments->where('completion_percentage', 0)->count();
        
        return [
            'datasets' => [
                [
                    'data' => [$completed, $inProgress, $notStarted],
                    'backgroundColor' => ['#10B981', '#F59E0B', '#EF4444'],
                    'borderColor' => ['#059669', '#D97706', '#DC2626'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Completed', 'In Progress', 'Not Started'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
