<?php

namespace App\Filament\Widgets;

use App\Filament\Support\DashboardMetrics;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardAlertsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 30;

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User
            && (DashboardMetrics::canViewOperations($user) || DashboardMetrics::canViewContent($user));
    }

    protected function getHeading(): ?string
    {
        return (string) __('admin_dashboard.widgets.alerts.heading');
    }

    protected function getDescription(): ?string
    {
        return (string) __('admin_dashboard.widgets.alerts.description');
    }

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        /** @var User $user */
        $user = Filament::auth()->user();
        $counts = DashboardMetrics::alertCounts($user);
        $stats = [];

        if (DashboardMetrics::canViewOperations($user)) {
            $stats[] = Stat::make((string) __('admin_dashboard.widgets.alerts.missing_info.label'), number_format($counts['missing_info']))
                ->description((string) __('admin_dashboard.widgets.alerts.missing_info.description'))
                ->icon('heroicon-o-document-magnifying-glass')
                ->color('warning');
            $stats[] = Stat::make((string) __('admin_dashboard.widgets.alerts.contact_agency.label'), number_format($counts['contact_agency']))
                ->description((string) __('admin_dashboard.widgets.alerts.contact_agency.description'))
                ->icon('heroicon-o-phone-arrow-up-right')
                ->color('danger');
            $stats[] = Stat::make((string) __('admin_dashboard.widgets.alerts.new_contacts.label'), number_format($counts['new_contacts']))
                ->description((string) __('admin_dashboard.widgets.alerts.new_contacts.description'))
                ->icon('heroicon-o-envelope')
                ->color('info');
        }

        if (DashboardMetrics::canViewContent($user)) {
            $stats[] = Stat::make((string) __('admin_dashboard.widgets.alerts.published_articles.label'), number_format($counts['latest_articles']))
                ->description((string) __('admin_dashboard.widgets.alerts.published_articles.description'))
                ->icon('heroicon-o-newspaper')
                ->color('success');
        }

        return $stats;
    }
}
