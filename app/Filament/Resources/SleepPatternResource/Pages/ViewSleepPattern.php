<?php

namespace App\Filament\Resources\SleepPatternResource\Pages;

use App\Filament\Resources\SleepPatternResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSleepPattern extends ViewRecord
{
    protected static string $resource = SleepPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No actions needed since sleep patterns are read-only
        ];
    }
}







