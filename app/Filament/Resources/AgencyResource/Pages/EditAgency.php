<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Filament\Resources\AgencyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditAgency extends EditRecord
{
    protected static string $resource = AgencyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_agencies.pages.edit.title', [
            'agency' => AgencyResource::localizedAgencyName($this->record),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_agencies.pages.edit.subtitle');
    }

    /**
     * @return array<DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('admin_agencies.actions.delete'))
                ->icon('heroicon-o-trash'),
        ];
    }
}
