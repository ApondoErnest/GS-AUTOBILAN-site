<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_services.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_services.pages.list.subtitle');
    }

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin_services.actions.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
