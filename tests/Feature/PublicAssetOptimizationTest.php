<?php

use Illuminate\Support\Facades\File;

it('ships WebP siblings for public raster imagery', function () {
    $rasters = collect(File::allFiles(public_path('images')))
        ->filter(fn (SplFileInfo $file): bool => in_array(strtolower($file->getExtension()), ['png', 'jpg', 'jpeg'], true))
        ->reject(fn (SplFileInfo $file): bool => $file->getFilename() === 'site_logo_pdf.png')
        ->values();

    expect($rasters)->not->toBeEmpty();

    $missing = $rasters
        ->map(fn (SplFileInfo $file): string => preg_replace('/\.(png|jpe?g)$/i', '.webp', $file->getPathname()))
        ->filter(fn (?string $path): bool => ! $path || ! File::exists($path))
        ->map(fn (?string $path): string => $path ? str_replace(public_path().'/', '', $path) : 'unknown')
        ->values()
        ->all();

    expect($missing)->toBe([]);
});

it('renders optimized WebP sources and loading attributes on public pages', function (string $path, array $needles) {
    $response = $this->get($path);

    $response
        ->assertOk()
        ->assertSee('images/site_logo.webp', false)
        ->assertSee('type="image/webp"', false)
        ->assertSee('decoding="async"', false)
        ->assertSee('loading="lazy"', false);

    foreach ($needles as $needle) {
        $response->assertSee($needle, false);
    }
})->with([
    'home' => ['/fr/accueil', [
        'images/homepage/hero-1.webp',
        'images/homepage/hero-1.png',
        'images/homepage/agence-3.webp',
        'images/homepage/prepare-visit.webp',
        'loading="eager"',
        'fetchpriority="high"',
    ]],
    'agencies' => ['/fr/nos-agences', [
        'images/agencies/hero-agencies.webp',
        'images/agencies/hero-agencies.png',
        'loading="eager"',
        'fetchpriority="high"',
    ]],
    'services' => ['/fr/services', [
        'images/servicespage/services-hero.webp',
        'images/servicespage/services-hero.png',
        'images/servicespage/light-vehicle.webp',
        'loading="eager"',
        'fetchpriority="high"',
    ]],
    'tariffs' => ['/fr/tarifs', [
        'image-set(',
        'images/servicespage/services-hero.webp',
        'images/servicespage/services-hero.png',
        'images/tariffs/light-vehicle.webp',
        'images/tariffs/mini bus.webp',
    ]],
    'inspection' => ['/fr/visite-technique', [
        'images/inspection/hero-inspection.webp',
        'images/inspection/hero-inspection.png',
        'loading="eager"',
        'fetchpriority="high"',
    ]],
    'about' => ['/fr/a-propos', [
        'images/aboutpage/hero-about.webp',
        'images/aboutpage/hero-about.png',
        'images/aboutpage/technician-about.webp',
        'loading="eager"',
        'fetchpriority="high"',
    ]],
    'contact' => ['/fr/contact', [
        'images/contacts/contact-calendar.svg',
        'loading="lazy"',
    ]],
]);

it('keeps the public frontend entry lightweight without SPA dependencies', function () {
    $package = json_decode(File::get(base_path('package.json')), true);
    $dependencyNames = array_merge(
        array_keys($package['dependencies'] ?? []),
        array_keys($package['devDependencies'] ?? []),
    );
    $dependencyList = implode("\n", $dependencyNames);

    expect($dependencyList)
        ->not->toContain('react')
        ->not->toContain('vue')
        ->not->toContain('@vitejs/plugin-react')
        ->not->toContain('@vitejs/plugin-vue')
        ->not->toContain('inertia');

    expect(filesize(resource_path('js/app.js')))->toBeLessThan(100000);
});
