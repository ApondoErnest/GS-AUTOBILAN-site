<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Filament\Resources\AgencyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListAgencies extends ListRecords
{
    protected static string $resource = AgencyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_agencies.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_agencies.pages.list.subtitle');
    }

    /**
     * @return array<CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin_agencies.actions.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
