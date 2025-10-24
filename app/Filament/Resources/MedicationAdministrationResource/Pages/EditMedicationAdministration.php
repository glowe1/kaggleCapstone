<?php

namespace App\Filament\Resources\MedicationAdministrationResource\Pages;

use App\Filament\Resources\MedicationAdministrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicationAdministration extends EditRecord
{
    protected static string $resource = MedicationAdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
