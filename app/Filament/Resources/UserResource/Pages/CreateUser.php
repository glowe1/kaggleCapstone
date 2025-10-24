<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure name field is populated from name components
        if (empty($data['name'])) {
            $firstName = $data['first_name'] ?? '';
            $middleNames = $data['middle_names'] ?? '';
            $lastName = $data['last_name'] ?? '';
            
            $data['name'] = trim(implode(' ', array_filter([$firstName, $middleNames, $lastName]))) ?: $data['email'];
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
