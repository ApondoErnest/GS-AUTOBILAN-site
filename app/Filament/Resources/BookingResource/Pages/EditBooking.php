<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_bookings.pages.edit.title', [
            'reference' => $this->record?->reference ?? '',
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_bookings.pages.edit.subtitle');
    }

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
