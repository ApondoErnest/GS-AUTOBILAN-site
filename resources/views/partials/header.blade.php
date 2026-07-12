@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $navItems = [
        ['label' => __('nav.home'), 'route' => 'home'],
        ['label' => __('nav.about'), 'route' => 'about'],
        ['label' => __('nav.agencies'), 'route' => 'agencies'],
        ['label' => __('nav.services'), 'route' => 'services'],
        ['label' => __('nav.tariffs'), 'route' => 'tariffs'],
        ['label' => __('nav.technical_inspection'), 'route' => 'technical_inspection'],
        ['label' => __('nav.contact'), 'route' => 'contact'],
    ];
@endphp

<header class="gs-header w-full bg-gs-surface shadow-lg shadow-gs-navy/10">
    <div class="hidden min-[1400px]:block">
        <div class="relative flex min-h-28 w-full items-center gap-6 border-b border-gs-concrete bg-white px-8">
            <a href="{{ route($routeLocale.'.home', [], false) }}" class="relative block h-20 w-64 shrink-0 overflow-hidden focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('chrome.brand_home_label') }}">
                <img
                    src="{{ asset('images/site_logo.png') }}"
                    alt="GS AUTOBILAN"
                    class="absolute left-1/2 top-1/2 w-[400px] max-w-none -translate-x-1/2 -translate-y-1/2"
                >
            </a>

            <nav class="flex min-w-0 flex-1 items-center justify-center gap-4 text-[15px] font-bold text-gs-ink" aria-label="Navigation principale">
                @foreach ($navItems as $item)
                    @php
                        $routeName = $routeLocale.'.'.$item['route'];
                        $isActive = request()->routeIs($routeName);
                    @endphp
                    <a
                        href="{{ route($routeName, [], false) }}"
                        @class([
                            'relative whitespace-nowrap py-4 transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2',
                            'font-bold text-gs-navy after:absolute after:-bottom-1 after:left-0 after:h-1 after:w-full after:bg-gs-accent before:absolute before:-bottom-1 before:left-[52%] before:h-1 before:w-9 before:bg-gs-primary' => $isActive,
                            'text-gs-ink hover:text-gs-navy' => ! $isActive,
                        ])
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex shrink-0 items-center gap-3">
                <a href="{{ route($routeLocale.'.tracking', [], false) }}" class="relative inline-flex min-h-12 items-center gap-2 overflow-hidden rounded-md border border-gs-primary px-3 pr-5 text-sm font-semibold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-calendar-days class="h-5 w-5 text-gs-accent" aria-hidden="true" />
                    <span>{{ __('actions.track_short') }}</span>
                    <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
                </a>

                <a href="{{ route($routeLocale.'.booking', [], false) }}" class="relative inline-flex min-h-12 items-center gap-2 overflow-hidden rounded-md bg-gs-navy px-3 pr-5 text-sm font-semibold text-white shadow-sm shadow-gs-navy/20 transition hover:bg-gs-bay focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-calendar class="h-5 w-5 text-white/90" aria-hidden="true" />
                    <span>{{ __('actions.book') }}</span>
                    <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
                </a>

                <span class="h-12 w-px bg-gs-concrete" aria-hidden="true"></span>

                <button type="button" class="inline-flex h-12 w-12 items-center justify-center text-gs-ink transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('actions.search') }}">
                    <x-heroicon-o-magnifying-glass class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>

            <div class="absolute bottom-0 left-1/2 h-2 w-80 -translate-x-1/2 overflow-hidden" aria-hidden="true">
                <span class="absolute bottom-0 left-0 h-1.5 w-[44%] rounded-tr-md bg-gs-navy"></span>
                <span class="absolute bottom-0 right-0 h-1.5 w-[44%] rounded-tl-md bg-gs-navy"></span>
                <span class="absolute bottom-0 left-1/2 flex h-2 -translate-x-1/2 gap-1">
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                </span>
            </div>
        </div>
    </div>

    <div class="min-[1400px]:hidden">
        <div class="flex h-20 items-center justify-between border-b border-gs-concrete bg-white px-5">
            <button type="button" data-mobile-menu-open aria-controls="gs-mobile-menu" aria-expanded="false" class="inline-flex h-12 w-12 items-center justify-center text-gs-navy transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('actions.open_menu') }}">
                <x-heroicon-o-bars-3 class="h-8 w-8" aria-hidden="true" />
            </button>

            <a href="{{ route($routeLocale.'.home', [], false) }}" class="relative block h-16 w-72 max-w-[64vw] overflow-hidden focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('chrome.brand_home_label') }}">
                <img
                    src="{{ asset('images/site_logo.png') }}"
                    alt="GS AUTOBILAN"
                    class="absolute left-1/2 top-1/2 w-[380px] max-w-none -translate-x-1/2 -translate-y-1/2"
                >
            </a>

            <button type="button" class="inline-flex h-12 w-12 items-center justify-center text-gs-navy transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('actions.user_area') }}">
                <x-heroicon-o-user-circle class="h-8 w-8" aria-hidden="true" />
            </button>
        </div>

        <div class="relative grid grid-cols-2 gap-3 border-b border-gs-concrete bg-white px-3 py-3">
            <a href="{{ route($routeLocale.'.booking', [], false) }}" class="relative inline-flex min-h-16 items-center justify-center gap-2 overflow-hidden rounded-md border border-gs-primary/25 bg-gs-soft px-2 pr-4 text-[13px] font-semibold text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/45 hover:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary min-[400px]:text-sm">
                <x-heroicon-o-calendar-days class="h-6 w-6 text-gs-accent min-[400px]:h-7 min-[400px]:w-7" aria-hidden="true" />
                <span class="whitespace-nowrap">{{ __('actions.book') }}</span>
                <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
            </a>

            <a href="{{ route($routeLocale.'.tracking', [], false) }}" class="relative inline-flex min-h-16 items-center justify-center gap-2 overflow-hidden rounded-md border border-gs-primary/25 bg-gs-soft px-2 pr-4 text-[13px] font-semibold text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/45 hover:bg-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary min-[400px]:text-sm">
                <x-heroicon-o-clipboard-document-list class="h-6 w-6 text-gs-accent min-[400px]:h-7 min-[400px]:w-7" aria-hidden="true" />
                <span class="whitespace-nowrap">{{ __('actions.track_mobile') }}</span>
                <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
            </a>

            <div class="absolute bottom-0 left-1/2 h-2 w-64 -translate-x-1/2 overflow-hidden" aria-hidden="true">
                <span class="absolute bottom-0 left-0 h-1.5 w-[43%] rounded-tr-md bg-gs-primary"></span>
                <span class="absolute bottom-0 right-0 h-1.5 w-[43%] rounded-tl-md bg-gs-primary"></span>
                <span class="absolute bottom-0 left-1/2 flex h-2 -translate-x-1/2 gap-1">
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                    <span class="block h-2 w-2 -skew-x-12 bg-gs-accent"></span>
                </span>
            </div>
        </div>
    </div>
</header>
