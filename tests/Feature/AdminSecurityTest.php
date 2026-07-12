<?php

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

it('redirects guests away from the admin dashboard', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

it('serves the admin login page', function () {
    $this->get('/admin/login')->assertOk();
});

it('keeps auth and CSRF middleware on the Filament admin panel', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->getMiddleware())->toContain(
        PreventRequestForgery::class,
    );

    expect($panel->getAuthMiddleware())->toContain(
        Authenticate::class,
    );
});

it('exposes a CSRF token meta tag on the public layout', function () {
    expect(file_get_contents(resource_path('views/layouts/app.blade.php')))
        ->toContain('csrf_token()');
});
