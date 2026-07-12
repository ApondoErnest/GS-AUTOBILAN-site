@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $mobileNavItems = [
        ['label' => __('nav.home'), 'route' => 'home'],
        ['label' => __('nav.about'), 'route' => 'about'],
        ['label' => __('nav.agencies'), 'route' => 'agencies'],
        ['label' => __('nav.services'), 'route' => 'services'],
        ['label' => __('nav.tariffs'), 'route' => 'tariffs'],
        ['label' => __('nav.technical_inspection'), 'route' => 'technical_inspection'],
        ['label' => __('nav.news'), 'route' => 'news'],
        ['label' => __('nav.contact'), 'route' => 'contact'],
    ];
@endphp

<div id="gs-mobile-menu" class="fixed inset-0 z-50 hidden min-[1400px]:hidden" aria-hidden="true">
    <div data-mobile-menu-close class="absolute inset-0 h-full w-full bg-gs-navy/60 backdrop-blur-sm" aria-hidden="true"></div>

    <aside class="relative flex h-full w-[min(92vw,25rem)] flex-col overflow-y-auto bg-white shadow-2xl shadow-gs-navy/30" role="dialog" aria-modal="true" aria-labelledby="gs-mobile-menu-title">
        <div class="h-1.5 bg-gs-accent" aria-hidden="true"></div>
        <div class="flex items-center justify-between border-b border-gs-concrete px-5 py-4">
            <a href="{{ route($routeLocale.'.home', [], false) }}" data-mobile-menu-link class="relative block h-14 w-56 max-w-[64vw] overflow-hidden focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('chrome.brand_home_label') }}">
                <img
                    src="{{ asset('images/site_logo.png') }}"
                    alt="GS AUTOBILAN"
                    class="absolute left-1/2 top-1/2 w-[320px] max-w-none -translate-x-1/2 -translate-y-1/2"
                >
            </a>

            <button type="button" data-mobile-menu-close data-mobile-menu-initial-focus class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-gs-concrete text-gs-navy transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" aria-label="{{ __('actions.close_menu') }}">
                <x-heroicon-o-x-mark class="h-7 w-7" aria-hidden="true" />
            </button>
        </div>

        <div class="border-b border-gs-concrete bg-gs-soft px-5 py-4">
            <p id="gs-mobile-menu-title" class="text-sm font-bold uppercase text-gs-navy">{{ __('chrome.menu_title') }}</p>
            <p class="mt-1 text-sm text-gs-grey">{{ __('chrome.slogan') }}</p>
        </div>

        <nav class="px-5 py-4" aria-label="Navigation mobile">
            <ul class="divide-y divide-gs-concrete">
                @foreach ($mobileNavItems as $item)
                    @php
                        $routeName = $routeLocale.'.'.$item['route'];
                        $isActive = request()->routeIs($routeName);
                    @endphp
                    <li>
                        <a
                            href="{{ route($routeName, [], false) }}"
                            data-mobile-menu-link
                            @class([
                                'relative flex min-h-12 items-center justify-between gap-3 py-2.5 pl-4 pr-2 text-base font-bold transition focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary',
                                'text-gs-navy before:absolute before:left-0 before:top-3 before:h-6 before:w-1.5 before:rounded-full before:bg-gs-accent' => $isActive,
                                'text-gs-ink hover:text-gs-primary' => ! $isActive,
                            ])
                        >
                            <span>{{ $item['label'] }}</span>
                            <x-heroicon-o-chevron-right class="h-4 w-4 text-gs-accent" aria-hidden="true" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="mt-auto space-y-4 border-t border-gs-concrete bg-gs-wall px-5 py-5">
            <div class="grid grid-cols-2 gap-3">
                <a href="tel:+237678844791" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-md border border-gs-primary/20 bg-white text-sm font-bold text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-phone class="h-5 w-5 text-gs-primary" aria-hidden="true" />
                    <span>{{ __('actions.call') }}</span>
                </a>
                <a href="https://wa.me/237678844791" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-md border border-gs-primary/20 bg-white text-sm font-bold text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <svg class="h-6 w-6 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                    </svg>
                    <span>{{ __('actions.whatsapp') }}</span>
                </a>
            </div>

            <div class="grid gap-3">
                <a href="{{ route($routeLocale.'.booking', [], false) }}" data-mobile-menu-link class="relative inline-flex min-h-12 items-center justify-between gap-3 overflow-hidden rounded-md bg-gs-primary px-4 pr-6 text-sm font-bold text-white shadow-md shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="h-5 w-5" aria-hidden="true" />
                        <span>{{ __('actions.book') }}</span>
                    </span>
                    <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
                    <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
                </a>

                <a href="{{ route($routeLocale.'.tracking', [], false) }}" data-mobile-menu-link class="relative inline-flex min-h-12 items-center justify-between gap-3 overflow-hidden rounded-md border border-gs-primary bg-white px-4 pr-6 text-sm font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-document-text class="h-5 w-5 text-gs-primary" aria-hidden="true" />
                        <span>{{ __('actions.track') }}</span>
                    </span>
                    <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
                    <span class="absolute inset-y-0 right-0 w-1.5 bg-gs-accent" aria-hidden="true"></span>
                </a>
            </div>

            @include('partials.language-switcher', ['variant' => 'light', 'label' => __('actions.language_mobile')])
        </div>
    </aside>
</div>
