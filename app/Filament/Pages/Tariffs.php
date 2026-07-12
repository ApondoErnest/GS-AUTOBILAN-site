<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class Tariffs extends AdminSectionPage
{
    protected static ?string $title = 'Tariffs';

    protected static ?string $slug = 'tariffs-overview';

    protected static bool $shouldRegisterNavigation = false;

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TARIFFS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
    ];
}
