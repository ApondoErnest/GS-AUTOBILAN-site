<?php

namespace App\Filament\Widgets;

use App\Filament\Support\DashboardMetrics;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class DashboardActivityWidget extends Widget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 40;

    protected string $view = 'filament.widgets.dashboard-activity-widget';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User
            && (DashboardMetrics::canViewOperations($user) || DashboardMetrics::canViewContent($user));
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var User $user */
        $user = Filament::auth()->user();

        return [
            'articles' => DashboardMetrics::canViewContent($user)
                ? DashboardMetrics::latestArticles()
                : collect(),
            'canViewContent' => DashboardMetrics::canViewContent($user),
            'canViewOperations' => DashboardMetrics::canViewOperations($user),
            'contactMessages' => DashboardMetrics::canViewOperations($user)
                ? DashboardMetrics::latestContactMessages($user)
                : collect(),
        ];
    }
}
