<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    private const SESSION_KEY = 'admin_locale';

    private const SUPPORTED_LOCALES = ['fr', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('locale');

        if (is_string($locale) && in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $request->session()->put(self::SESSION_KEY, $locale);
        } else {
            $locale = $request->session()->get(self::SESSION_KEY, config('app.locale', 'fr'));
        }

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = 'fr';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
