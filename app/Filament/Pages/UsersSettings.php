<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class UsersSettings extends AdminSectionPage
{
    protected static ?string $title = 'Users & Settings';

    protected static ?string $slug = 'users-settings';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_USERS_SETTINGS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
    ];
}
