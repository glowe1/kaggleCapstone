<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Resident;
use App\Models\User;
use App\Models\Branch;
use App\Models\VitalSign;
use App\Models\Assessment;
use App\Models\Appointment;
use App\Models\LeaveRequest;
use App\Models\Assignment;

class ResidentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Residents', Resident::count())
                ->description('Active residents in care')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Total Caregivers', User::where('role', 'caregiver')->count())
                ->description('Active staff members')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),
            
            Stat::make('Total Branches', Branch::count())
                ->description('Facility locations')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info'),
            
            Stat::make('Active Assignments', Assignment::where('is_active', true)->count())
                ->description('Current assignments')
                ->descriptionIcon('heroicon-m-link')
                ->color('warning'),
        ];
    }
}
