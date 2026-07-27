<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ThrottleTrackingLookup
{
    private const DECAY_SECONDS = 900;

    private const MAX_ATTEMPTS = 5;

    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->key($request);

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return $this->limitedResponse($request, $key);
        }

        try {
            $response = $next($request);
        } catch (ValidationException $exception) {
            RateLimiter::hit($key, self::DECAY_SECONDS);

            throw $exception;
        }

        if ($this->hasTrackingLookupError($request)) {
            RateLimiter::hit($key, self::DECAY_SECONDS);
        } elseif ($response->isSuccessful()) {
            RateLimiter::clear($key);
        }

        return $response;
    }

    private function hasTrackingLookupError(Request $request): bool
    {
        if (! $request->hasSession()) {
            return false;
        }

        $errors = $request->session()->get('errors');

        return $errors instanceof ViewErrorBag && $errors->has('tracking_lookup');
    }

    private function key(Request $request): string
    {
        return 'tracking-lookup|'.$request->ip();
    }

    private function limitedResponse(Request $request, string $key): RedirectResponse
    {
        $seconds = RateLimiter::availableIn($key);
        $minutes = max(1, (int) ceil($seconds / 60));

        return redirect()
            ->route($this->locale($request).'.tracking')
            ->withInput($request->except('_token'))
            ->withErrors(['tracking_lookup' => __('tracking.lookup.errors.throttled', ['minutes' => $minutes])])
            ->withHeaders([
                'Retry-After' => (string) $seconds,
                'X-RateLimit-Limit' => (string) self::MAX_ATTEMPTS,
                'X-RateLimit-Remaining' => '0',
            ]);
    }

    private function locale(Request $request): string
    {
        $routeName = (string) $request->route()?->getName();

        if (str_starts_with($routeName, 'en.')) {
            return 'en';
        }

        return $request->segment(1) === 'en' ? 'en' : 'fr';
    }
}
