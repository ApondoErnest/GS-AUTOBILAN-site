<?php

namespace App\Http\Responses;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class PublicFormSpamResponder implements SpamResponder
{
    public function respond(Request $request, Closure $next)
    {
        $message = __('security.public_forms.spam');

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 422);
        }

        return redirect()
            ->back()
            ->withInput($this->safeInput($request))
            ->withErrors(['public_form' => $message]);
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
