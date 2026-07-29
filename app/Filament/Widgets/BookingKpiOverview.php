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

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User && DashboardMetrics::canViewOperations($user);
    }

    protected function getHeading(): ?string
    {
        return (string) __('admin_dashboard.widgets.booking.heading');
    }

    protected function getDescription(): ?string
    {
        return (string) __('admin_dashboard.widgets.booking.description');
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
            Stat::make((string) __('admin_dashboard.widgets.booking.total.label'), number_format($counts['total']))
                ->description((string) __('admin_dashboard.widgets.booking.total.description'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
            Stat::make((string) __('admin_dashboard.widgets.booking.new.label'), number_format($counts['new']))
                ->description((string) __('admin_dashboard.widgets.booking.new.description'))
                ->icon('heroicon-o-sparkles')
                ->color('info'),
            Stat::make((string) __('admin_dashboard.widgets.booking.pending.label'), number_format($counts['pending']))
                ->description((string) __('admin_dashboard.widgets.booking.pending.description'))
                ->icon('heroicon-o-clock')
                ->color('warning'),
            Stat::make((string) __('admin_dashboard.widgets.booking.confirmed.label'), number_format($counts['confirmed']))
                ->description((string) __('admin_dashboard.widgets.booking.confirmed.description'))
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make((string) __('admin_dashboard.widgets.booking.completed.label'), number_format($counts['completed']))
                ->description((string) __('admin_dashboard.widgets.booking.completed.description'))
                ->icon('heroicon-o-flag')
                ->color('success'),
            Stat::make((string) __('admin_dashboard.widgets.booking.no_show.label'), number_format($counts['no_show']))
                ->description((string) __('admin_dashboard.widgets.booking.no_show.description'))
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
