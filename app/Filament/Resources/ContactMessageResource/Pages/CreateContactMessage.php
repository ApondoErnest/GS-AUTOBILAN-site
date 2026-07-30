<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateContactMessage extends CreateRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_contact_messages.pages.create.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_contact_messages.pages.create.subtitle');
    }

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
