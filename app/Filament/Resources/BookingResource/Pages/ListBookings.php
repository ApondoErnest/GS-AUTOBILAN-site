<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('admin_bookings.pages.list.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('admin_bookings.pages.list.subtitle');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
