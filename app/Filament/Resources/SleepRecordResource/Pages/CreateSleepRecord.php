<?php

namespace App\Filament\Resources\SleepRecordResource\Pages;

use App\Filament\Resources\SleepRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSleepRecord extends CreateRecord
{
    protected static string $resource = SleepRecordResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        
        // Automatically set branch_id from resident if not already set
        if (isset($data['resident_id']) && !isset($data['branch_id'])) {
            $resident = \App\Models\Resident::find($data['resident_id']);
            if ($resident && $resident->branch_id) {
                $data['branch_id'] = $resident->branch_id;
            }
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
