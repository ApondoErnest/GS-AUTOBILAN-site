@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $quickLinks = trans('footer.quick_links');
    $services = trans('footer.services');
    $agencies = trans('footer.agencies');
    $features = trans('footer.features');
@endphp

<footer class="gs-footer bg-gs-wall">
    <section class="bg-gs-wall px-4 py-8 sm:px-6 lg:px-8" aria-label="{{ __('actions.quick_actions') }}">
        <div class="relative mx-auto max-w-[1400px] overflow-hidden rounded-xl border border-gs-concrete bg-white p-6 shadow-xl shadow-gs-navy/10 sm:p-8">
            <div class="absolute left-0 top-0 h-2 w-64 -skew-x-12 bg-gs-accent" aria-hidden="true"></div>
            <div class="absolute right-0 top-0 h-2 w-[68%] rounded-tr-xl bg-gs-primary" aria-hidden="true"></div>

            <div class="relative grid gap-6 lg:grid-cols-[1.35fr_2.15fr] lg:items-center">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-gs-soft text-gs-primary sm:h-24 sm:w-24">
                        <x-heroicon-o-calendar-days class="h-12 w-12" aria-hidden="true" />
                    </div>

                    <div>
                        <h2 class="max-w-[22rem] text-2xl font-bold leading-tight text-gs-navy sm:text-3xl">
                            {{ __('footer.ready_cta.title') }}
                        </h2>
                        <p class="mt-2 max-w-sm text-base leading-relaxed text-gs-grey sm:text-lg">
                            {{ __('footer.ready_cta.copy') }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <a href="{{ route($routeLocale.'.booking', [], false) }}" class="inline-flex min-h-16 items-center justify-between gap-4 rounded-md bg-gs-primary px-4 font-bold text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                        <span class="inline-flex items-center gap-3">
                            <x-heroicon-o-calendar-days class="h-8 w-8" aria-hidden="true" />
                            <span class="whitespace-nowrap">{{ __('actions.book') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>

                    <a href="{{ route($routeLocale.'.tracking', [], false) }}" class="inline-flex min-h-16 items-center justify-between gap-4 rounded-md border border-gs-primary bg-white px-4 font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                        <span class="inline-flex items-center gap-3">
                            <x-heroicon-o-document-text class="h-8 w-8 text-gs-primary" aria-hidden="true" />
                            <span class="whitespace-nowrap">{{ __('actions.track') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>

                    <a href="https://wa.me/237678844791" class="inline-flex min-h-16 items-center justify-between gap-4 rounded-md border border-gs-primary bg-white px-4 font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                        <span class="inline-flex items-center gap-3">
                            <svg class="h-9 w-9 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                            </svg>
                            <span>{{ __('actions.whatsapp') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="h-1.5 bg-gs-accent" aria-hidden="true"></div>
    <section class="bg-gs-navy text-white" aria-label="{{ __('chrome.footer_aria') }}">
        <div class="mx-auto grid max-w-[1500px] gap-8 px-4 py-10 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-12 xl:grid-cols-[1.1fr_1.25fr_.78fr_.9fr_1.22fr]">
            <div>
                <a href="{{ route($routeLocale.'.home', [], false) }}" class="relative block h-24 w-72 max-w-full overflow-hidden" aria-label="{{ __('chrome.brand_home_label') }}">
                    <img
                        src="{{ asset('images/site_logo.png') }}"
                        alt="GS AUTOBILAN"
                        class="absolute left-1/2 top-1/2 w-[430px] max-w-none -translate-x-1/2 -translate-y-1/2 brightness-0 invert"
                    >
                </a>

                <div class="mt-5 flex gap-4">
                    <span class="mt-1 h-12 w-2 rounded-sm bg-gs-accent" aria-hidden="true"></span>
                    <p class="text-2xl font-bold leading-tight">
                        {!! str_replace(',', ',<br>', e(__('chrome.slogan'))) !!}
                    </p>
                </div>

                <p class="mt-6 max-w-xs text-sm leading-relaxed text-white/80">
                    {{ __('footer.intro') }}
                </p>

                <ul class="mt-6 space-y-3 text-sm text-white/90">
                    <li class="flex items-center gap-3 border-b border-white/10 pb-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25">
                            <x-heroicon-o-shield-check class="h-5 w-5" aria-hidden="true" />
                        </span>
                        <span>{{ $features[0] }}</span>
                    </li>
                    <li class="flex items-center gap-3 border-b border-white/10 pb-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25">
                            <x-heroicon-o-calendar-days class="h-5 w-5" aria-hidden="true" />
                        </span>
                        <span>{{ $features[1] }}</span>
                    </li>
                    <li class="flex items-center gap-3 border-b border-white/10 pb-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25">
                            <x-heroicon-o-check-badge class="h-5 w-5" aria-hidden="true" />
                        </span>
                        <span>{{ $features[2] }}</span>
                    </li>
                </ul>

                <div class="mt-8 flex gap-3" aria-label="{{ __('chrome.socials_aria') }}">
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25 text-lg font-bold transition hover:border-white hover:bg-white/10" aria-label="Facebook">f</a>
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25 transition hover:border-white hover:bg-white/10" aria-label="Instagram">
                        <x-heroicon-o-camera class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25 transition hover:border-white hover:bg-white/10" aria-label="YouTube">
                        <x-heroicon-o-play class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a href="https://wa.me/237678844791" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25 text-gs-success transition hover:border-white hover:bg-white/10" aria-label="WhatsApp">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold uppercase">{{ __('footer.headings.agencies') }}</h2>
                <div class="mt-2 h-1 w-14 bg-gs-accent" aria-hidden="true"></div>
                <div class="mt-4 space-y-3">
                    @foreach ($agencies as $agency)
                        <article class="relative overflow-hidden rounded-lg border border-white/20 bg-white/5 p-4 pl-6">
                            <span class="absolute left-0 top-5 h-20 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>
                            <div class="flex gap-3">
                                <x-heroicon-o-map-pin class="mt-1 h-6 w-6 shrink-0 text-white/85" aria-hidden="true" />
                                <div>
                                    <h3 class="text-lg font-bold leading-tight">{{ $agency['name'] }}</h3>
                                    <p class="mt-2 text-sm leading-relaxed text-white/85">{{ $agency['address'] }}</p>
                                </div>
                            </div>
                            <p class="mt-3 flex gap-3 text-sm leading-relaxed text-white/85">
                                <x-heroicon-o-clock class="mt-0.5 h-5 w-5 shrink-0" aria-hidden="true" />
                                <span>{{ $agency['hours'] }}</span>
                            </p>
                            <p class="mt-3 flex gap-3 text-sm text-white/90">
                                <x-heroicon-o-phone class="h-5 w-5 shrink-0" aria-hidden="true" />
                                <span>{{ $agency['phone'] }}</span>
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="xl:border-l xl:border-white/15 xl:pl-7">
                <h2 class="text-lg font-bold uppercase">{{ __('footer.headings.quick_links') }}</h2>
                <div class="mt-2 h-1 w-14 bg-gs-accent" aria-hidden="true"></div>
                <ul class="mt-5 divide-y divide-white/10 text-sm">
                    @foreach ($quickLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="flex min-h-11 items-center gap-3 text-white/90 transition hover:text-white">
                                <x-heroicon-o-chevron-right class="h-4 w-4 text-gs-accent" aria-hidden="true" />
                                <span>{{ $link['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="xl:border-l xl:border-white/15 xl:pl-7">
                <h2 class="text-lg font-bold uppercase">{{ __('footer.headings.services') }}</h2>
                <div class="mt-2 h-1 w-14 bg-gs-accent" aria-hidden="true"></div>
                <ul class="mt-5 divide-y divide-white/10 text-sm">
                    @foreach ($services as $service)
                        <li class="flex min-h-11 items-center gap-3 text-white/90">
                            @if ($service['icon'] === 'academic-cap')
                                <x-heroicon-o-academic-cap class="h-5 w-5 shrink-0" aria-hidden="true" />
                            @elseif ($service['icon'] === 'arrow-path')
                                <x-heroicon-o-arrow-path class="h-5 w-5 shrink-0" aria-hidden="true" />
                            @elseif ($service['icon'] === 'building-office-2')
                                <x-heroicon-o-building-office-2 class="h-5 w-5 shrink-0" aria-hidden="true" />
                            @else
                                <x-heroicon-o-truck class="h-5 w-5 shrink-0" aria-hidden="true" />
                            @endif
                            <span>{{ $service['label'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="xl:border-l xl:border-white/15 xl:pl-7">
                <h2 class="text-lg font-bold uppercase">{{ __('footer.headings.contact_actions') }}</h2>
                <div class="mt-2 h-1 w-14 bg-gs-accent" aria-hidden="true"></div>

                <div class="mt-7">
                    <h3 class="font-bold uppercase">{{ __('footer.headings.direction') }}</h3>
                    <ul class="mt-3 space-y-3 text-sm text-white/90">
                        <li class="flex gap-3">
                            <x-heroicon-o-map-pin class="h-5 w-5 shrink-0" aria-hidden="true" />
                            <span>{{ __('footer.contact.address') }}</span>
                        </li>
                        <li class="flex gap-3">
                            <x-heroicon-o-envelope class="h-5 w-5 shrink-0" aria-hidden="true" />
                            <span>{{ __('footer.contact.box') }}</span>
                        </li>
                        <li class="flex gap-3">
                            <x-heroicon-o-phone class="h-5 w-5 shrink-0" aria-hidden="true" />
                            <span>{{ __('footer.contact.phone') }}</span>
                        </li>
                        <li class="flex gap-3">
                            <x-heroicon-o-envelope class="h-5 w-5 shrink-0" aria-hidden="true" />
                            <span>{{ __('footer.contact.email') }}</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-6 space-y-3 border-t border-white/20 pt-6">
                    <a href="{{ route($routeLocale.'.booking', [], false) }}" class="flex min-h-14 items-center justify-between gap-4 rounded-md bg-gs-primary px-4 text-sm font-bold text-white transition hover:bg-gs-bay">
                        <span class="inline-flex items-center gap-3">
                            <x-heroicon-o-calendar-days class="h-6 w-6" aria-hidden="true" />
                            <span class="whitespace-nowrap">{{ __('actions.book') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a href="{{ route($routeLocale.'.tracking', [], false) }}" class="flex min-h-14 items-center justify-between gap-4 rounded-md border border-white/70 px-4 text-sm font-bold text-white transition hover:bg-white/10">
                        <span class="inline-flex items-center gap-3">
                            <x-heroicon-o-document-text class="h-6 w-6" aria-hidden="true" />
                            <span class="whitespace-nowrap">{{ __('actions.track') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a href="https://wa.me/237678844791" class="flex min-h-14 items-center justify-between gap-4 rounded-md border border-white/70 px-4 text-sm font-bold text-white transition hover:bg-white/10">
                        <span class="inline-flex items-center gap-3">
                            <svg class="h-6 w-6 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                            </svg>
                            <span class="whitespace-nowrap">{{ __('actions.whatsapp_write') }}</span>
                        </span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>

                <div class="mt-7">
                    @include('partials.language-switcher', ['variant' => 'footer', 'label' => __('actions.language_footer')])
                </div>
            </div>
        </div>
    </section>

    <div class="h-1.5 bg-gs-accent" aria-hidden="true"></div>
    <section class="bg-gs-navy text-white">
        <div class="mx-auto flex max-w-[1500px] flex-col gap-4 px-4 py-6 text-sm text-white/90 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <p>{{ __('footer.legal.copyright') }}</p>
            <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="{{ __('chrome.legal_aria') }}">
                <a href="#" class="transition hover:text-white">{{ __('footer.legal.mentions') }}</a>
                <span aria-hidden="true">|</span>
                <a href="#" class="transition hover:text-white">{{ __('footer.legal.privacy') }}</a>
                <span aria-hidden="true">|</span>
                <a href="#" class="transition hover:text-white">{{ __('footer.legal.terms') }}</a>
            </nav>
            <p>{{ __('footer.legal.made_with') }} <span class="text-gs-accent">♥</span> {{ __('footer.legal.for_safety') }}</p>
        </div>
    </section>
</footer>
