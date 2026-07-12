<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class Communication extends AdminSectionPage
{
    protected static ?string $title = 'Communication';

    protected static ?string $slug = 'communication';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_COMMUNICATION;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'agency_admin',
    ];
}
