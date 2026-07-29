<?php

namespace App\Filament\Resources\TariffResource\Pages;

use App\Filament\Resources\TariffResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListTariffs extends ListRecords
{
    protected static string $resource = TariffResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_tariffs.resource.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_tariffs.resource.pages.list.subtitle');
    }

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin_tariffs.resource.actions.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
