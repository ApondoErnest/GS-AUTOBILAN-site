<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Page;

abstract class AdminSectionPage extends Page
{
    /**
     * @var list<string>
     */
    protected static array $allowedRoles = [];

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();
        $panel = Filament::getCurrentOrDefaultPanel();

        return $user instanceof User
            && $panel !== null
            && $user->canAccessPanel($panel)
            && (static::$allowedRoles === [] || $user->hasAnyRole(static::$allowedRoles));
    }
}
