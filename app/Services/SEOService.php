<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Route;

class SEOService
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public function meta(?string $locale = null, array $overrides = []): array
    {
        $locale = $this->normalizeLocale($locale);
        $defaults = $this->defaults();

        $title = $overrides['title']
            ?? $this->localizedValue($defaults, 'title', $locale)
            ?? config('app.name', 'GS AUTOBILAN');

        $description = $overrides['description']
            ?? $this->localizedValue($defaults, 'description', $locale)
            ?? '';

        return [
            'title' => $title,
            'description' => $description,
            'og' => [
                'title' => $overrides['og_title'] ?? $title,
                'description' => $overrides['og_description'] ?? $description,
                'image' => $overrides['og_image'] ?? null,
            ],
            'canonical' => $overrides['canonical'] ?? null,
            'hreflang' => $overrides['hreflang'] ?? [],
        ];
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public function forRoute(string $routeBaseName, array $parameters = [], ?string $locale = null, array $overrides = []): array
    {
        $locale = $this->normalizeLocale($locale);
        $hreflang = [];

        foreach ($this->locales() as $candidateLocale) {
            $routeName = "{$candidateLocale}.{$routeBaseName}";

            if (Route::has($routeName)) {
                $hreflang[$candidateLocale] = route($routeName, $parameters);
            }
        }

        return $this->meta($locale, [
            'canonical' => $hreflang[$locale] ?? null,
            'hreflang' => $hreflang,
            ...$overrides,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function defaults(): array
    {
        return Setting::query()->where('key', 'seo_defaults')->first()?->value ?? [];
    }

    /**
     * @param  array<string, mixed>  $source
     */
    private function localizedValue(array $source, string $field, string $locale): ?string
    {
        foreach (array_unique([$locale, $this->fallbackLocale(), 'fr', 'en']) as $candidateLocale) {
            $value = data_get($source, "{$field}_{$candidateLocale}");

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return null;
    }

    private function normalizeLocale(?string $locale): string
    {
        $locale ??= app()->getLocale() ?: config('app.locale', 'fr');

        return in_array($locale, $this->locales(), true) ? $locale : 'fr';
    }

    private function fallbackLocale(): string
    {
        $fallbackLocale = config('app.fallback_locale', 'en');

        return in_array($fallbackLocale, $this->locales(), true) ? $fallbackLocale : 'en';
    }

    /**
     * @return list<string>
     */
    private function locales(): array
    {
        return ['fr', 'en'];
    }
}
