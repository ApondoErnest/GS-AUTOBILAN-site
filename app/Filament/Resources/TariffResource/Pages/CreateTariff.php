<?php

namespace App\Filament\Resources\TariffResource\Pages;

use App\Filament\Resources\TariffResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTariff extends CreateRecord
{
    protected static string $resource = TariffResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_tariffs.resource.pages.create.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_tariffs.resource.pages.create.subtitle');
    }
}
