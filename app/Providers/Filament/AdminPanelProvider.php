<?php

namespace App\Providers\Filament;

use App\Filament\AdminNavigation;
use App\Filament\Auth\Login;
use App\Filament\Pages\AgenciesServices;
use App\Filament\Pages\Communication;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Operations;
use App\Filament\Pages\Tariffs;
use App\Filament\Pages\UsersSettings;
use App\Filament\Pages\WebsiteContent;
use App\Filament\Support\GsAvatarProvider;
use App\Http\Middleware\SetAdminLocale;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->brandName('GS AUTOBILAN')
            ->brandLogo(fn (): HtmlString => new HtmlString(view('filament.partials.admin-logo')->render()))
            ->brandLogoHeight('2.75rem')
            ->colors([
                'primary' => [
                    50 => '#eef5ff',
                    100 => '#d7e8ff',
                    200 => '#b9d6ff',
                    300 => '#86b8ff',
                    400 => '#4c91f4',
                    500 => '#226fda',
                    600 => '#145db3',
                    700 => '#0d4a8f',
                    800 => '#0b3a75',
                    900 => '#082f61',
                    950 => '#062a5c',
                ],
            ])
            ->defaultAvatarProvider(GsAvatarProvider::class)
            ->navigationGroups(AdminNavigation::groups())
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn (): string => view('filament.partials.admin-topbar-controls')->render(),
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn (): string => view('filament.partials.admin-sidebar-footer')->render(),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                AgenciesServices::class,
                Communication::class,
                Dashboard::class,
                Operations::class,
                Tariffs::class,
                UsersSettings::class,
                WebsiteContent::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->navigationGroup('Users & Settings')
                    ->navigationLabel('Roles')
                    ->navigationIcon('heroicon-o-shield-check')
                    ->navigationSort(20),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->middleware([
                SetAdminLocale::class,
            ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
