<?php

namespace App\Filament\Resources\SleepPatternResource\Pages;

use App\Filament\Resources\SleepPatternResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSleepPattern extends EditRecord
{
    protected static string $resource = SleepPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
