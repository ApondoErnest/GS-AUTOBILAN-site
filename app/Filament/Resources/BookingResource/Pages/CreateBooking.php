<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Services\BookingReferenceService;
use App\Services\DocumentReadinessService;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $agencyAdmin = BookingResource::currentAgencyAdmin();

        if ($agencyAdmin !== null) {
            $data['agency_id'] = $agencyAdmin->assigned_agency_id;
        }

        $data['reference'] = app(BookingReferenceService::class)->generate();

        return $data;
    }

    protected function afterCreate(): void
    {
        app(DocumentReadinessService::class)->createDefaultFor($this->record);
    }
}
