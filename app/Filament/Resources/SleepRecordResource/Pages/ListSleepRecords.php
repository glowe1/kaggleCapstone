<?php

namespace App\Filament\Resources\SleepRecordResource\Pages;

use App\Filament\Resources\SleepRecordResource;
use App\Filament\Resources\SleepPatternResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSleepRecords extends ListRecords
{
    protected static string $resource = SleepRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('viewPatterns')
                ->label('View Sleep Patterns')
                ->icon('heroicon-o-chart-bar')
                ->url(SleepPatternResource::getUrl('index'))
                ->color('info')
                ->outlined(),
        ];
    }
}
