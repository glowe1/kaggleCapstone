<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\VitalSign;
use App\Models\Assessment;
use App\Models\Appointment;
use App\Models\LeaveRequest;

class ActivityStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Assessments', Assessment::where('completion_percentage', '<', 100)->count())
                ->description('Awaiting completion')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
            
            Stat::make('Today\'s Vitals', VitalSign::whereDate('measurement_date', today())->count())
                ->description('Vital signs recorded')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),
            
            Stat::make('Upcoming Appointments', Appointment::whereDate('appointment_date', '>=', today())->count())
                ->description('Scheduled appointments')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            
            Stat::make('Pending Leave Requests', LeaveRequest::where('status', 'pending')->count())
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
