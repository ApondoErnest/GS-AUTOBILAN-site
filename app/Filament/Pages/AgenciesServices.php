<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class AgenciesServices extends AdminSectionPage
{
    protected static ?string $title = 'Agencies & Services';

    protected static ?string $slug = 'agencies-services';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_AGENCIES_SERVICES;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
        'content_manager',
    ];
}
