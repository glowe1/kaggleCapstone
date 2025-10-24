<?php

namespace App\Filament\Resources\VitalRangeResource\Pages;

use App\Filament\Resources\VitalRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVitalRanges extends ListRecords
{
    protected static string $resource = VitalRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
