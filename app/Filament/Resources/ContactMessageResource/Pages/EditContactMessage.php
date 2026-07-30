<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_contact_messages.pages.edit.title', [
            'message' => ContactMessageResource::messageTitle($this->record),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_contact_messages.pages.edit.subtitle');
    }

    /**
     * @return array<DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('admin_contact_messages.actions.delete'))
                ->icon('heroicon-o-trash'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $agencyAdmin = ContactMessageResource::currentAgencyAdmin();

        if ($agencyAdmin !== null) {
            $data['agency_id'] = $agencyAdmin->assigned_agency_id;
        }

        return $data;
    }
}
