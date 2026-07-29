<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $seo = $seo ?? [];
        $pageTitle = $seo['title'] ?? trim($__env->yieldContent('title', $title ?? config('app.name')));
        $metaDescription = $seo['description'] ?? null;
        $canonical = $seo['canonical'] ?? null;
        $hreflang = $seo['hreflang'] ?? [];
        $og = $seo['og'] ?? [];
        $jsonLd = $seo['json_ld'] ?? [];
        $ogTitle = $og['title'] ?? $pageTitle;
        $ogDescription = $og['description'] ?? $metaDescription;
        $ogLocale = app()->getLocale() === 'en' ? 'en_US' : 'fr_FR';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    @if (filled($metaDescription))
        <meta name="description" content="{{ $metaDescription }}">
    @endif
    @if (filled($canonical))
        <link rel="canonical" href="{{ $canonical }}">
        <meta property="og:url" content="{{ $canonical }}">
    @endif
    @foreach ($hreflang as $alternateLocale => $alternateUrl)
        <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}">
    @endforeach
    @if (filled($hreflang['fr'] ?? null))
        <link rel="alternate" hreflang="x-default" href="{{ $hreflang['fr'] }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name', 'GS AUTOBILAN') }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    @if (filled($ogDescription))
        <meta property="og:description" content="{{ $ogDescription }}">
    @endif
    @if (filled($og['image'] ?? null))
        <meta property="og:image" content="{{ $og['image'] }}">
    @endif
    @foreach ($jsonLd as $schema)
        <script type="application/ld+json">@json($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @endforeach
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.top-strip')
    @include('partials.header')
    @include('partials.mobile-menu')

    <main id="main" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.back-to-top')

    @stack('scripts')
</body>
</html>
