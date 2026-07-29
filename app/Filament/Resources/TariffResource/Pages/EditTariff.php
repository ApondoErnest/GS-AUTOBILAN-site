<?php

namespace App\Filament\Resources\TariffResource\Pages;

use App\Filament\Resources\TariffResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditTariff extends EditRecord
{
    protected static string $resource = TariffResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_tariffs.resource.pages.edit.title', [
            'tariff' => TariffResource::localizedVehicleType($this->record),
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_tariffs.resource.pages.edit.subtitle');
    }

    /**
     * @return array<DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('admin_tariffs.resource.actions.delete'))
                ->icon('heroicon-o-trash'),
        ];
    }
}
