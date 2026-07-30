<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_contact_messages.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_contact_messages.pages.list.subtitle');
    }

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin_contact_messages.actions.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
