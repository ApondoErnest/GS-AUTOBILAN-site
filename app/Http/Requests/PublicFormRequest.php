<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class PublicFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function cleanedString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    protected function normalizedPhone(?string $value): ?string
    {
        $value = $this->cleanedString($value);

        if ($value === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value) ?? '';

        return $digits === '' ? null : '+'.$digits;
    }

    protected function normalizedReference(?string $value): ?string
    {
        $value = $this->cleanedString($value);

        return $value === null
            ? null
            : preg_replace('/\s+/', '', Str::upper($value));
    }

    protected function normalizedVehicleRegistration(?string $value): ?string
    {
        $value = $this->cleanedString($value);

        return $value === null
            ? null
            : preg_replace('/\s+/', '', Str::upper($value));
    }
}
