<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use App\Filament\Widgets\BookingAgencyBreakdown;
use App\Filament\Widgets\BookingKpiOverview;
use App\Filament\Widgets\DashboardActivityWidget;
use App\Filament\Widgets\DashboardAlertsOverview;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_DASHBOARD;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_dashboard.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_dashboard.title');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-dashboard-page'];
    }

    /**
     * @return int|array<string, ?int>
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'xl' => 2,
        ];
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_dashboard.header.intro');
    }

    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            BookingKpiOverview::class,
            BookingAgencyBreakdown::class,
            DashboardAlertsOverview::class,
            DashboardActivityWidget::class,
            AccountWidget::class,
        ];
    }
}
