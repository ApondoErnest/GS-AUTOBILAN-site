<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

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
            'json_ld' => $overrides['json_ld'] ?? [],
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

    public function sitemap(): Sitemap
    {
        $sitemap = Sitemap::create();

        foreach ($this->staticSitemapPages() as $page) {
            foreach ($this->locales() as $locale) {
                $routeName = "{$locale}.{$page['name']}";

                if (! Route::has($routeName)) {
                    continue;
                }

                $url = Url::create(route($routeName))
                    ->setChangeFrequency($page['change_frequency'])
                    ->setPriority($page['priority']);

                $this->addLocalizedAlternates($url, $page['name']);

                $sitemap->add($url);
            }
        }

        $sitemap->add($this->publishedArticleUrls());

        return $sitemap;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function localBusinessSchemas(?string $locale = null): array
    {
        $locale = $this->normalizeLocale($locale);
        $cards = trans('agencies.cards', [], $locale);

        if (! is_array($cards)) {
            return [];
        }

        return collect($cards)
            ->map(fn (array $agency): array => $this->localBusinessSchema($agency, $locale))
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function defaults(): array
    {
        if (! Schema::hasTable('settings')) {
            return [];
        }

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

    /**
     * @return list<array{name: string, change_frequency: string, priority: float}>
     */
    private function staticSitemapPages(): array
    {
        return [
            ['name' => 'home', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 1.0],
            ['name' => 'about', 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.7],
            ['name' => 'agencies', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.9],
            ['name' => 'services', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.8],
            ['name' => 'tariffs', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.8],
            ['name' => 'technical_inspection', 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.8],
            ['name' => 'booking', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.9],
            ['name' => 'tracking', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.7],
            ['name' => 'news', 'change_frequency' => Url::CHANGE_FREQUENCY_WEEKLY, 'priority' => 0.7],
            ['name' => 'contact', 'change_frequency' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.8],
        ];
    }

    private function addLocalizedAlternates(Url $url, string $routeBaseName, array $parametersByLocale = []): void
    {
        foreach ($this->locales() as $alternateLocale) {
            $routeName = "{$alternateLocale}.{$routeBaseName}";

            if (Route::has($routeName)) {
                $url->addAlternate(route($routeName, $parametersByLocale[$alternateLocale] ?? []), $alternateLocale);
            }
        }

        if (Route::has("fr.{$routeBaseName}")) {
            $url->addAlternate(route("fr.{$routeBaseName}", $parametersByLocale['fr'] ?? []), 'x-default');
        }
    }

    /**
     * @return list<Url>
     */
    private function publishedArticleUrls(): array
    {
        if (! Schema::hasTable('articles')) {
            return [];
        }

        return Article::query()
            ->published()
            ->get()
            ->flatMap(function (Article $article): array {
                $parametersByLocale = collect($this->locales())
                    ->mapWithKeys(fn (string $locale): array => [$locale => ['slug' => $article->getAttribute("slug_{$locale}")]])
                    ->filter(fn (array $parameters): bool => filled($parameters['slug'] ?? null))
                    ->all();

                return collect($parametersByLocale)
                    ->map(function (array $parameters, string $locale) use ($article, $parametersByLocale): Url {
                        $url = Url::create(route("{$locale}.article.show", $parameters))
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.6);

                        if ($article->updated_at || $article->published_at) {
                            $url->setLastModificationDate($article->updated_at ?? $article->published_at);
                        }

                        $this->addLocalizedAlternates($url, 'article.show', $parametersByLocale);

                        return $url;
                    })
                    ->all();
            })
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $agency
     * @return array<string, mixed>
     */
    private function localBusinessSchema(array $agency, string $locale): array
    {
        $id = (string) ($agency['id'] ?? str($agency['name'] ?? 'agency')->slug());
        $url = route("{$locale}.agencies").'#'.$id;
        $phones = $this->phoneNumbers($agency['phone'] ?? null);
        $coordinates = $this->coordinates($agency['mapHref'] ?? null);
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => $url,
            'name' => $agency['name'] ?? config('app.name', 'GS AUTOBILAN'),
            'description' => trans('agencies.meta_description', [], $locale),
            'url' => $url,
            'logo' => asset('images/site_logo.png'),
            'image' => asset('images/site_logo.png'),
            'telephone' => $phones,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => trim(strip_tags((string) ($agency['address'] ?? ''))),
                'addressLocality' => 'Yaounde',
                'addressCountry' => 'CM',
            ],
            'geo' => $coordinates === null ? null : [
                '@type' => 'GeoCoordinates',
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ],
            'hasMap' => $agency['mapHref'] ?? null,
            'openingHours' => $this->openingHours($agency['hours'] ?? null),
            'areaServed' => [
                [
                    '@type' => 'City',
                    'name' => 'Yaounde',
                ],
                [
                    '@type' => 'Country',
                    'name' => 'Cameroon',
                ],
            ],
        ];

        return array_filter($schema, fn (mixed $value): bool => $value !== null && $value !== [] && $value !== '');
    }

    /**
     * @return list<string>
     */
    private function phoneNumbers(mixed $phone): array
    {
        if (! is_string($phone)) {
            return [];
        }

        return collect(explode('/', $phone))
            ->map(fn (string $value): string => trim($value))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array{latitude: float, longitude: float}|null
     */
    private function coordinates(mixed $mapHref): ?array
    {
        if (! is_string($mapHref)) {
            return null;
        }

        $query = parse_url($mapHref, PHP_URL_QUERY);

        if (! is_string($query)) {
            return null;
        }

        parse_str($query, $parameters);

        if (! is_string($parameters['q'] ?? null)) {
            return null;
        }

        $coordinates = array_map('trim', explode(',', $parameters['q']));

        if (count($coordinates) !== 2 || ! is_numeric($coordinates[0]) || ! is_numeric($coordinates[1])) {
            return null;
        }

        return [
            'latitude' => (float) $coordinates[0],
            'longitude' => (float) $coordinates[1],
        ];
    }

    /**
     * @return list<string>
     */
    private function openingHours(mixed $hours): array
    {
        if (! is_string($hours)) {
            return [];
        }

        return collect(explode("\n", str_replace('<br>', "\n", $hours)))
            ->map(fn (string $value): string => trim(strip_tags($value)))
            ->filter()
            ->values()
            ->all();
    }
}
