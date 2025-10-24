<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Models\Resident;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure branch_id is set if resident is selected
        if (isset($data['resident_id']) && $data['resident_id']) {
            $resident = Resident::find($data['resident_id']);
            if ($resident && $resident->branch_id) {
                $data['branch_id'] = $resident->branch_id;
            }
        }

        // Ensure created_by is set
        $data['created_by'] = auth()->id();

        return $data;
    }
}
