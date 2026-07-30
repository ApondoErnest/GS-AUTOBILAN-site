<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_settings.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_settings.pages.list.subtitle');
    }

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin_settings.actions.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
