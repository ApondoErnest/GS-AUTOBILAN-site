<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $agencyAdmin = BookingResource::currentAgencyAdmin();

        if ($agencyAdmin !== null) {
            $data['agency_id'] = $agencyAdmin->assigned_agency_id;
        }

        return $data;
    }
}
