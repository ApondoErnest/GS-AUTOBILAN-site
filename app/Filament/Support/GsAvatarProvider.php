<?php

namespace App\Filament\Support;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class GsAvatarProvider implements AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        $name = trim((string) Filament::getNameForDefaultAvatar($record));

        $initials = str($name)
            ->explode(' ')
            ->filter(fn (string $segment): bool => filled($segment))
            ->take(2)
            ->map(fn (string $segment): string => mb_strtoupper(mb_substr($segment, 0, 1)))
            ->join('');

        $initials = $initials !== '' ? $initials : 'GS';

        $escapedName = htmlspecialchars($name !== '' ? $name : 'GS AUTOBILAN Admin', ENT_QUOTES | ENT_XML1, 'UTF-8');
        $escapedInitials = htmlspecialchars($initials, ENT_QUOTES | ENT_XML1, 'UTF-8');

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" role="img" aria-label="{$escapedName}">
    <defs>
        <linearGradient id="gs-avatar-bg" x1="12" y1="10" x2="86" y2="86" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#0b3a75"/>
            <stop offset="1" stop-color="#145db3"/>
        </linearGradient>
    </defs>
    <rect width="96" height="96" rx="48" fill="url(#gs-avatar-bg)"/>
    <path d="M0 80h96v16H0z" fill="#c8202f" opacity=".96"/>
    <path d="M58 80h38v16H58z" fill="#f5c542"/>
    <text x="48" y="46" text-anchor="middle" dominant-baseline="middle" fill="#ffffff" font-family="Inter, Arial, sans-serif" font-size="33" font-weight="800" letter-spacing="0">{$escapedInitials}</text>
</svg>
SVG;

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}
