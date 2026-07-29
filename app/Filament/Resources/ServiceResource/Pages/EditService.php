<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_services.pages.edit.title', [
            'service' => ServiceResource::localizedServiceTitle($this->record),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_services.pages.edit.subtitle');
    }

    /**
     * @return array<DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('admin_services.actions.delete'))
                ->icon('heroicon-o-trash'),
        ];
    }
}
