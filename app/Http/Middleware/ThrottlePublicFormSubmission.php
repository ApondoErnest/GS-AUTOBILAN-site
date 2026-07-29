<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ThrottlePublicFormSubmission
{
    public const DECAY_SECONDS = 900;

    public const MAX_ATTEMPTS = 5;

    public function handle(Request $request, Closure $next, string $form = 'public'): Response
    {
        $key = $this->key($request, $form);

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return $this->limitedResponse($request, $key);
        }

        try {
            return $next($request);
        } finally {
            RateLimiter::hit($key, self::DECAY_SECONDS);
        }
    }

    public static function limiterKey(string $form, string $ip): string
    {
        return 'public-form|'.$form.'|'.$ip;
    }

    private function key(Request $request, string $form): string
    {
        return self::limiterKey($form, (string) $request->ip());
    }

    private function limitedResponse(Request $request, string $key): Response
    {
        $seconds = RateLimiter::availableIn($key);
        $minutes = max(1, (int) ceil($seconds / 60));
        $message = __('security.public_forms.throttled', ['minutes' => $minutes]);
        $headers = [
            'Retry-After' => (string) $seconds,
            'X-RateLimit-Limit' => (string) self::MAX_ATTEMPTS,
            'X-RateLimit-Remaining' => '0',
        ];

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], IlluminateResponse::HTTP_TOO_MANY_REQUESTS, $headers);
        }

        return redirect()
            ->back()
            ->withInput($this->safeInput($request))
            ->withErrors(['public_form' => $message])
            ->withHeaders($headers);
    }

    /**
     * @return array<string, mixed>
     */
    private function safeInput(Request $request): array
    {
        $except = ['_token', (string) config('honeypot.valid_from_field_name')];
        $honeypotPrefix = (string) config('honeypot.name_field_name');

        foreach (array_keys($request->all()) as $key) {
            if (Str::startsWith((string) $key, $honeypotPrefix)) {
                $except[] = (string) $key;
            }
        }

        return $request->except($except);
    }
}
