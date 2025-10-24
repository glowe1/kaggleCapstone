<?php

namespace App\Filament\Resources\SleepRecordResource\Pages;

use App\Filament\Resources\SleepRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSleepRecord extends EditRecord
{
    protected static string $resource = SleepRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
