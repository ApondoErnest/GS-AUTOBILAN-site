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

    protected ?string $heading = 'Alerts and content pulse';

    protected ?string $description = 'Operational follow-ups and recently publishable content signals.';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User
            && (DashboardMetrics::canViewOperations($user) || DashboardMetrics::canViewContent($user));
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
            $stats[] = Stat::make('Missing information', number_format($counts['missing_info']))
                ->description('Document readiness alerts')
                ->icon('heroicon-o-document-magnifying-glass')
                ->color('warning');
            $stats[] = Stat::make('Contact agency', number_format($counts['contact_agency']))
                ->description('Client should call or visit')
                ->icon('heroicon-o-phone-arrow-up-right')
                ->color('danger');
            $stats[] = Stat::make('New contact messages', number_format($counts['new_contacts']))
                ->description('Unprocessed public messages')
                ->icon('heroicon-o-envelope')
                ->color('info');
        }

        if (DashboardMetrics::canViewContent($user)) {
            $stats[] = Stat::make('Published articles', number_format($counts['latest_articles']))
                ->description('Visible news and advice')
                ->icon('heroicon-o-newspaper')
                ->color('success');
        }

        return $stats;
    }
}
