<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Filament\Resources\AgencyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateAgency extends CreateRecord
{
    protected static string $resource = AgencyResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_agencies.pages.create.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_agencies.pages.create.subtitle');
    }
}
