<?php

namespace App\Filament\Resources\VitalSignResource\Pages;

use App\Filament\Resources\VitalSignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVitalSigns extends ListRecords
{
    protected static string $resource = VitalSignResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\Action::make('view_vitals')
                ->label('View Vitals')
                ->url(route('filament.admin.pages.view-vitals'))
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->openUrlInNewTab(),
            
            Actions\CreateAction::make()
                ->label('New Vital Sign'),
        ];

        // Only show Vitals Range button for users who can manage vital ranges
        if (auth()->user()->hasPermission('view_vital_ranges')) {
            $actions[] = Actions\Action::make('vital_ranges')
                ->label('Vitals Range')
                ->url(route('filament.admin.resources.vital-ranges.index'))
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('warning')
                ->openUrlInNewTab();
        }

        return $actions;
    }
}