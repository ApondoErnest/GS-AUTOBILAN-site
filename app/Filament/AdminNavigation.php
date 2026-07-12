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
     * @return list<NavigationGroup>
     */
    public static function groups(): array
    {
        return [
            NavigationGroup::make(self::GROUP_DASHBOARD),
            NavigationGroup::make(self::GROUP_OPERATIONS),
            NavigationGroup::make(self::GROUP_CONTENT),
            NavigationGroup::make(self::GROUP_AGENCIES_SERVICES),
            NavigationGroup::make(self::GROUP_TARIFFS),
            NavigationGroup::make(self::GROUP_COMMUNICATION),
            NavigationGroup::make(self::GROUP_USERS_SETTINGS),
        ];
    }
}
