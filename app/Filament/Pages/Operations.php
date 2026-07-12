<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class Operations extends AdminSectionPage
{
    protected static ?string $title = 'Operations';

    protected static ?string $slug = 'operations';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_OPERATIONS;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
    ];
}
