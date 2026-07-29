<?php

namespace App\Filament;

use Filament\Navigation\NavigationGroup;

final class AdminNavigation
{
    public const GROUP_DASHBOARD = 'Dashboard';

    public const GROUP_OPERATIONS = 'Operations';

    public const GROUP_CONTENT = 'Website Content';

    public const GROUP_AGENCIES_SERVICES = 'Agencies & Services';

    public const GROUP_TARIFFS = 'Tariffs';

    public const GROUP_COMMUNICATION = 'Communication';

    public const GROUP_USERS_SETTINGS = 'Users & Settings';

    /**
     * @return list<string>
     */
    public static function labels(): array
    {
        return [
            self::GROUP_DASHBOARD,
            self::GROUP_OPERATIONS,
            self::GROUP_CONTENT,
            self::GROUP_AGENCIES_SERVICES,
            self::GROUP_TARIFFS,
            self::GROUP_COMMUNICATION,
            self::GROUP_USERS_SETTINGS,
        ];
    }

    /**
     * @return array<string, NavigationGroup>
     */
    public static function groups(): array
    {
        return [
            self::GROUP_DASHBOARD => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.dashboard')),
            self::GROUP_OPERATIONS => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.operations')),
            self::GROUP_CONTENT => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.content')),
            self::GROUP_AGENCIES_SERVICES => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.agencies_services')),
            self::GROUP_TARIFFS => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.tariffs')),
            self::GROUP_COMMUNICATION => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.communication')),
            self::GROUP_USERS_SETTINGS => NavigationGroup::make(fn (): string => (string) __('admin_chrome.groups.users_settings')),
        ];
    }
}
