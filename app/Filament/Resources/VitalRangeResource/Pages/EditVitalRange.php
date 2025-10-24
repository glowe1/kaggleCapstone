<?php

namespace App\Filament\Resources\VitalRangeResource\Pages;

use App\Filament\Resources\VitalRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVitalRange extends EditRecord
{
    protected static string $resource = VitalRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
