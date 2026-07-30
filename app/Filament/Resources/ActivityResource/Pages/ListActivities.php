<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListActivities extends ListRecords
{
    protected static string $resource = ActivityResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_activity.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_activity.pages.list.subtitle');
    }

    protected function authorizeAccess(): void
    {
        abort_unless(ActivityResource::canAccess(), 403);
    }
}
