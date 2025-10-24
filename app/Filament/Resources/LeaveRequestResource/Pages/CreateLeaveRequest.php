<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If user is a caregiver, pre-fill their staff_id
        if (auth()->user()->hasRole('caregiver')) {
            $data['staff_id'] = auth()->id();
        }

        return $data;
    }
}
