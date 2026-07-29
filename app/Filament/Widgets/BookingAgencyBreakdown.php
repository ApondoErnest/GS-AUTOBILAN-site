<?php

namespace App\Filament\Widgets;

use App\Filament\Support\DashboardMetrics;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingAgencyBreakdown extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 20;

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User && DashboardMetrics::canViewOperations($user);
    }

    protected function getHeading(): ?string
    {
        return (string) __('admin_dashboard.widgets.agency.heading');
    }

    protected function getDescription(): ?string
    {
        return (string) __('admin_dashboard.widgets.agency.description');
    }

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        /** @var User $user */
        $user = Filament::auth()->user();

        return DashboardMetrics::agencyBookingBreakdown($user)
            ->map(fn (array $agency): Stat => Stat::make($agency['label'], number_format($agency['count']))
                ->description((string) __('admin_dashboard.widgets.agency.visible_bookings'))
                ->icon('heroicon-o-building-office-2')
                ->color('primary'))
            ->all();
    }
}
