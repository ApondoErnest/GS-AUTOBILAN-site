<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Set the application locale from the first URL segment.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale') ?? $request->segment(1);

        if (! in_array($locale, ['fr', 'en'], true)) {
            $locale = config('app.locale', 'fr');
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
