<?php

namespace App\Filament\Widgets;

use App\Filament\Support\DashboardMetrics;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingKpiOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 10;

    protected ?string $heading = 'Booking KPIs';

    protected ?string $description = 'Requests and appointment outcomes for your visible operations.';

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
        $counts = DashboardMetrics::bookingCounts($user);

        return [
            Stat::make('Total bookings', number_format($counts['total']))
                ->description('All visible requests')
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
            Stat::make('New requests', number_format($counts['new']))
                ->description('Waiting for first review')
                ->icon('heroicon-o-sparkles')
                ->color('info'),
            Stat::make('Pending confirmations', number_format($counts['pending']))
                ->description('Needs appointment confirmation')
                ->icon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Confirmed', number_format($counts['confirmed']))
                ->description('Ready for the visit')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Completed', number_format($counts['completed']))
                ->description('Finished appointments')
                ->icon('heroicon-o-flag')
                ->color('success'),
            Stat::make('No-shows', number_format($counts['no_show']))
                ->description('Missed appointments')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
