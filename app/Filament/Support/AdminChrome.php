<?php

namespace App\Filament\Support;

use App\Models\User;
use Filament\Facades\Filament;

class AdminChrome
{
    /**
     * @return array{user: User, roleLabel: string, scopeLabel: string, updatedAtLabel: string}|null
     */
    public static function context(): ?array
    {
        $user = Filament::auth()->user();

        if (! $user instanceof User) {
            return null;
        }

        $user->loadMissing('assignedAgency');

        return [
            'roleLabel' => self::roleLabel($user),
            'scopeLabel' => self::scopeLabel($user),
            'updatedAtLabel' => now()->format('d/m/Y H:i'),
            'user' => $user,
        ];
    }

    public static function roleLabel(User $user): string
    {
        return match (true) {
            $user->hasRole('super_admin') => (string) __('admin_chrome.roles.super_admin'),
            $user->hasRole('agency_admin') => (string) __('admin_chrome.roles.agency_admin'),
            $user->hasRole('content_manager') => (string) __('admin_chrome.roles.content_manager'),
            default => (string) __('admin_chrome.roles.staff'),
        };
    }

    public static function scopeLabel(User $user): string
    {
        if ($user->hasRole('super_admin')) {
            return (string) __('admin_chrome.scopes.all_agencies');
        }

        if ($user->hasRole('agency_admin')) {
            return DashboardMetrics::localizedAgencyName($user->assignedAgency)
                ?? (string) __('admin_chrome.scopes.agency_unassigned');
        }

        if ($user->hasRole('content_manager')) {
            return (string) __('admin_chrome.scopes.content_workspace');
        }

        return (string) __('admin_chrome.scopes.staff_workspace');
    }
}
