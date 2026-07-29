<?php

use App\Http\Middleware\SetLocale;
use App\Http\Middleware\ThrottlePublicFormSubmission;
use App\Http\Middleware\ThrottleTrackingLookup;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'honeypot' => \Spatie\Honeypot\ProtectAgainstSpam::class,
            'public.form.throttle' => ThrottlePublicFormSubmission::class,
            'setLocale' => SetLocale::class,
            'tracking.lookup.throttle' => ThrottleTrackingLookup::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
