<?php

namespace App\Filament\Resources\DocumentReadinessResource\Pages;

use App\Filament\Resources\DocumentReadinessResource;
use App\Models\Booking;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentReadiness extends CreateRecord
{
    protected static string $resource = DocumentReadinessResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = DocumentReadinessResource::currentUser();

        if ($user?->hasRole('agency_admin')) {
            abort_unless(
                Booking::query()
                    ->whereKey($data['booking_id'] ?? null)
                    ->where('agency_id', $user->assigned_agency_id)
                    ->exists(),
                403,
            );
        }

        $data['updated_by'] = $user?->id;

        return $data;
    }
}
