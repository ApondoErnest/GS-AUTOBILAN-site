<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use App\Filament\Resources\ActivityResource;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\UserResource;
use App\Models\Setting;
use App\Models\User;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class UsersSettings extends AdminSectionPage
{
    protected string $view = 'filament.pages.users-settings';

    protected static ?string $title = 'Users & Settings';

    protected static ?string $slug = 'users-settings';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_USERS_SETTINGS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
    ];

    public static function getNavigationLabel(): string
    {
        return (string) __('admin_users_settings.navigation_label');
    }

    public function getTitle(): string|Htmlable
    {
        return (string) __('admin_users_settings.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return (string) __('admin_users_settings.subtitle');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['gs-admin-users-settings-page'];
    }

    /**
     * @return list<array{label: string, value: string, description: string, icon: string, tone: string}>
     */
    public function summaryCards(): array
    {
        $totalUsers = User::query()->count();
        $activeUsers = User::query()->where('is_active', true)->count();
        $superAdmins = $this->roleCount('super_admin');
        $settings = Setting::query()->count();

        return [
            [
                'label' => (string) __('admin_users_settings.summary.users.label'),
                'value' => number_format($totalUsers),
                'description' => (string) __('admin_users_settings.summary.users.description'),
                'icon' => 'users',
                'tone' => 'blue',
            ],
            [
                'label' => (string) __('admin_users_settings.summary.active.label'),
                'value' => number_format($activeUsers),
                'description' => (string) __('admin_users_settings.summary.active.description'),
                'icon' => 'shield',
                'tone' => 'green',
            ],
            [
                'label' => (string) __('admin_users_settings.summary.super_admins.label'),
                'value' => number_format($superAdmins),
                'description' => (string) __('admin_users_settings.summary.super_admins.description'),
                'icon' => 'key',
                'tone' => $superAdmins > 1 ? 'yellow' : 'red',
            ],
            [
                'label' => (string) __('admin_users_settings.summary.settings.label'),
                'value' => number_format($settings),
                'description' => (string) __('admin_users_settings.summary.settings.description'),
                'icon' => 'cog',
                'tone' => 'red',
            ],
        ];
    }

    /**
     * @return list<array{label: string, description: string, href: string, icon: string, tone: string}>
     */
    public function quickLinks(): array
    {
        return collect([
            UserResource::canAccess() ? [
                'label' => (string) __('admin_users_settings.quick_links.users.label'),
                'description' => (string) __('admin_users_settings.quick_links.users.description'),
                'href' => UserResource::getUrl(),
                'icon' => 'users',
                'tone' => 'blue',
            ] : null,
            SettingResource::canAccess() ? [
                'label' => (string) __('admin_users_settings.quick_links.settings.label'),
                'description' => (string) __('admin_users_settings.quick_links.settings.description'),
                'href' => SettingResource::getUrl(),
                'icon' => 'cog',
                'tone' => 'red',
            ] : null,
            ActivityResource::canAccess() ? [
                'label' => (string) __('admin_users_settings.quick_links.audit.label'),
                'description' => (string) __('admin_users_settings.quick_links.audit.description'),
                'href' => ActivityResource::getUrl(),
                'icon' => 'clipboard',
                'tone' => 'green',
            ] : null,
        ])
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return list<array{label: string, count: int, percent: int, description: string}>
     */
    public function roleItems(): array
    {
        $totalUsers = User::query()->count();

        return collect(UserResource::roleOptions())
            ->map(function (string $label, string $role) use ($totalUsers): array {
                $count = $this->roleCount($role);

                return [
                    'label' => $label,
                    'count' => $count,
                    'percent' => $totalUsers > 0 ? (int) round(($count / $totalUsers) * 100) : 0,
                    'description' => (string) __('admin_users_settings.roles.metric', [
                        'count' => number_format($count),
                        'total' => number_format($totalUsers),
                    ]),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, User>
     */
    public function latestUsers(): Collection
    {
        return User::query()
            ->with(['assignedAgency', 'roles'])
            ->latest('updated_at')
            ->limit(5)
            ->get();
    }

    /**
     * @return Collection<int, Activity>
     */
    public function latestActivities(): Collection
    {
        return Activity::query()
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    /**
     * @return list<array{label: string, count: int, description: string, href: string, icon: string, tone: string}>
     */
    public function attentionItems(): array
    {
        return collect([
            [
                'label' => (string) __('admin_users_settings.attention.inactive_users.label'),
                'count' => User::query()->where('is_active', false)->count(),
                'description' => (string) __('admin_users_settings.attention.inactive_users.description'),
                'href' => UserResource::getUrl(),
                'icon' => 'lock',
                'tone' => 'gray',
            ],
            [
                'label' => (string) __('admin_users_settings.attention.unassigned_agency_admins.label'),
                'count' => User::query()
                    ->whereNull('assigned_agency_id')
                    ->whereHas('roles', fn ($query) => $query->where('name', 'agency_admin'))
                    ->count(),
                'description' => (string) __('admin_users_settings.attention.unassigned_agency_admins.description'),
                'href' => UserResource::getUrl(),
                'icon' => 'building',
                'tone' => 'yellow',
            ],
            [
                'label' => (string) __('admin_users_settings.attention.users_without_roles.label'),
                'count' => User::query()->whereDoesntHave('roles')->count(),
                'description' => (string) __('admin_users_settings.attention.users_without_roles.description'),
                'href' => UserResource::getUrl(),
                'icon' => 'shield',
                'tone' => 'red',
            ],
            [
                'label' => (string) __('admin_users_settings.attention.recent_audit.label'),
                'count' => Activity::query()->where('created_at', '>=', now()->subDay())->count(),
                'description' => (string) __('admin_users_settings.attention.recent_audit.description'),
                'href' => ActivityResource::getUrl(),
                'icon' => 'clipboard',
                'tone' => 'blue',
            ],
        ])
            ->filter(fn (array $item): bool => $item['count'] > 0)
            ->values()
            ->all();
    }

    public function userUrl(User $user): string
    {
        return UserResource::canEdit($user)
            ? UserResource::getUrl('edit', ['record' => $user])
            : UserResource::getUrl();
    }

    public function userTitle(User $user): string
    {
        return UserResource::userTitle($user);
    }

    public function userMeta(User $user): string
    {
        return collect([
            UserResource::rolesSummary($user),
            UserResource::agencyLabel($user->assignedAgency),
        ])->filter()->join(' - ') ?: (string) __('admin_users_settings.empty_value');
    }

    public function userStatusLabel(User $user): string
    {
        return UserResource::visibilityLabel((bool) $user->is_active);
    }

    public function userTone(User $user): string
    {
        return $user->is_active ? 'green' : 'gray';
    }

    public function activityDescription(Activity $activity): string
    {
        return ActivityResource::activityDescription($activity);
    }

    public function activityMeta(Activity $activity): string
    {
        return collect([
            ActivityResource::logLabel($activity->log_name),
            ActivityResource::subjectLabel($activity->subject_type, $activity->subject_id),
        ])->filter()->join(' - ') ?: (string) __('admin_users_settings.empty_value');
    }

    public function activityTone(Activity $activity): string
    {
        return ActivityResource::eventTone($activity->event);
    }

    public function activityStatusLabel(Activity $activity): string
    {
        return ActivityResource::eventLabel($activity->event);
    }

    private function roleCount(string $role): int
    {
        return User::query()
            ->whereHas('roles', fn ($query) => $query->where('name', $role))
            ->count();
    }
}
