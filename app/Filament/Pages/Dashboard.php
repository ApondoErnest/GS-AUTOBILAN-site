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
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_DASHBOARD;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

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
