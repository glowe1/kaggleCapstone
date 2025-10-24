<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\MedicationAdministration;

class SimpleMedicationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $completed = MedicationAdministration::where('status', 'completed')->count();
        $missed = MedicationAdministration::where('status', 'missed')->count();
        $refused = MedicationAdministration::where('status', 'refused')->count();
        $total = MedicationAdministration::count();

        return [
            Stat::make('Completed', $completed)
                ->description('Successfully administered')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            
            Stat::make('Missed', $missed)
                ->description('Missed administrations')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            
            Stat::make('Refused', $refused)
                ->description('Refused by residents')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
            
            Stat::make('Total', $total)
                ->description('All medication records')
                ->color('primary')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
