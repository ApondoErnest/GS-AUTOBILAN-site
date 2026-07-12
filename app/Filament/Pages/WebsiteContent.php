<?php

namespace App\Filament\Pages;

use App\Filament\AdminNavigation;
use BackedEnum;
use UnitEnum;

class WebsiteContent extends AdminSectionPage
{
    protected static ?string $title = 'Website Content';

    protected static ?string $slug = 'website-content';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_CONTENT;

    protected static ?string $navigationLabel = 'Overview';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    protected static array $allowedRoles = [
        'super_admin',
        'content_manager',
    ];
}
