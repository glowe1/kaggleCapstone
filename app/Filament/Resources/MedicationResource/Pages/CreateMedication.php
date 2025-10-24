<?php

namespace App\Filament\Resources\MedicationResource\Pages;

use App\Filament\Resources\MedicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMedication extends CreateRecord
{
    protected static string $resource = MedicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        
        // Automatically set branch_id from resident if not already set
        if (isset($data['resident_id']) && !isset($data['branch_id'])) {
            $resident = \App\Models\Resident::find($data['resident_id']);
            if ($resident && $resident->branch_id) {
                $data['branch_id'] = $resident->branch_id;
            }
        }
        
        // Ensure name is set if not provided
        if (empty($data['name'])) {
            $drug = \App\Models\Drug::find($data['drug_id'] ?? null);
            $resident = \App\Models\Resident::find($data['resident_id'] ?? null);
            if ($drug && $resident) {
                $data['name'] = $drug->name . ' - ' . $resident->name;
            }
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
