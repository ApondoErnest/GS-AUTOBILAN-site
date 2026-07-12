@php
    $variant = $variant ?? 'light';
    $label = $label ?? __('actions.language');
    $currentLocale = app()->getLocale() ?: 'fr';
    $frHref = route('fr.home', [], false);
    $enHref = route('en.home', [], false);
    $isDark = in_array($variant, ['strip', 'footer'], true);

    $navClass = match ($variant) {
        'strip' => 'flex min-h-10 items-center gap-2 text-base sm:gap-3',
        'footer' => 'flex items-center gap-4 text-lg',
        default => 'inline-flex items-center rounded-full border border-gs-primary/15 bg-gs-soft p-1 text-sm font-bold text-gs-navy',
    };

    $activeClass = $isDark
        ? 'relative font-bold text-white after:absolute after:-bottom-1.5 after:left-0 after:h-1 after:w-full after:rounded-full after:bg-gs-accent'
        : 'rounded-full bg-white px-3 py-1.5 text-gs-navy shadow-sm shadow-gs-navy/10';

    $inactiveClass = $isDark
        ? 'text-white/80 transition hover:text-white'
        : 'rounded-full px-3 py-1.5 text-gs-ink-muted transition hover:bg-white/70 hover:text-gs-navy';

    $separatorClass = $isDark ? 'h-6 w-px bg-white/50' : 'h-6 w-px bg-gs-primary/20';
@endphp

<nav class="{{ $navClass }}" aria-label="{{ $label }}">
    <a href="{{ $frHref }}" @if ($currentLocale === 'fr') aria-current="true" @endif class="{{ $currentLocale === 'fr' ? $activeClass : $inactiveClass }}">
        FR
    </a>
    <span class="{{ $separatorClass }}" aria-hidden="true"></span>
    <a href="{{ $enHref }}" @if ($currentLocale === 'en') aria-current="true" @endif class="{{ $currentLocale === 'en' ? $activeClass : $inactiveClass }}">
        EN
    </a>
</nav>
