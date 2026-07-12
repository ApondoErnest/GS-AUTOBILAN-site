<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactMessage extends CreateRecord
{
    protected static string $resource = ContactMessageResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $agencyAdmin = ContactMessageResource::currentAgencyAdmin();

        if ($agencyAdmin !== null) {
            $data['agency_id'] = $agencyAdmin->assigned_agency_id;
        }

        return $data;
    }
}
