<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Medication;
use App\Models\MedicationAdministration;
use Carbon\Carbon;

class MedicationStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalMedications = Medication::count();
        $activeMedications = Medication::where('is_active', true)->count();
        $totalAdministrations = MedicationAdministration::count();
        $todayAdministrations = MedicationAdministration::whereDate('administered_at', Carbon::today())->count();
        $missedDoses = MedicationAdministration::where('status', 'missed')->count();
        $pendingDoses = MedicationAdministration::where('status', 'pending')->count();

        return [
            Stat::make('Total Medications', $totalMedications)
                ->description('All medications in system')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary')
                ->icon('heroicon-o-cube'),
            
            Stat::make('Active Medications', $activeMedications)
                ->description('Currently active medications')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            
            Stat::make("Today's Administrations", $todayAdministrations)
                ->description('Administrations today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info')
                ->icon('heroicon-o-calendar-days'),
            
            Stat::make('Total Administrations', $totalAdministrations)
                ->description('All-time administrations')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning')
                ->icon('heroicon-o-chart-bar'),
            
            Stat::make('Missed Doses', $missedDoses)
                ->description('Missed medication doses')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
            
            Stat::make('Pending Doses', $pendingDoses)
                ->description('Pending medication doses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray')
                ->icon('heroicon-o-clock'),
        ];
    }
}
