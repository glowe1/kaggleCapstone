<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\VitalSign;

class SimpleVitalsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = VitalSign::count();
        $approved = VitalSign::where('status', 'approved')->count();
        $pending = VitalSign::where('status', 'pending_review')->count();
        $critical = VitalSign::where('status', 'critical')->count();

        return [
            Stat::make('Total Vitals', $total)
                ->description('All vital sign records')
                ->color('primary')
                ->icon('heroicon-o-heart'),
            
            Stat::make('Approved', $approved)
                ->description('Approved vitals')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            
            Stat::make('Pending Review', $pending)
                ->description('Awaiting review')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            
            Stat::make('Critical', $critical)
                ->description('Critical readings')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
