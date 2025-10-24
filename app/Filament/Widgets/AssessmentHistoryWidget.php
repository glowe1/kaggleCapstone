<?php

namespace App\Filament\Widgets;

use App\Models\Assessment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class AssessmentHistoryWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAssessments = Assessment::count();
        $completedAssessments = Assessment::where('status', 'approved')->count();
        $pendingAssessments = Assessment::whereIn('status', ['draft', 'submitted'])->count();
        $thisMonthAssessments = Assessment::whereMonth('created_at', now()->month)->count();

        return [
            Stat::make('Total Assessments', $totalAssessments)
                ->description('All time assessments')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Completed', $completedAssessments)
                ->description('Approved assessments')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pending', $pendingAssessments)
                ->description('Draft or submitted')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('This Month', $thisMonthAssessments)
                ->description('Assessments this month')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}












