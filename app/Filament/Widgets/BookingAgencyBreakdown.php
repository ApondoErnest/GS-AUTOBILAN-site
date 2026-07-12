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

    protected ?string $heading = 'Bookings by agency';

    protected ?string $description = 'Breakdown follows the same agency scope as the KPI cards.';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User && DashboardMetrics::canViewOperations($user);
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
                ->description('Visible bookings')
                ->icon('heroicon-o-building-office-2')
                ->color('primary'))
            ->all();
    }
}
