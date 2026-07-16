@extends('layouts.app')

@section('title', __('agencies.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $bookingHref = route($routeLocale.'.booking', [], false);
    $trustItems = trans('agencies.hero.trust_items');
    $agencyCards = trans('agencies.cards');
@endphp

@section('content')
    <section class="relative isolate min-h-[560px] overflow-hidden bg-gs-navy text-white sm:min-h-[700px] lg:min-h-[680px]" aria-labelledby="agencies-hero-title" data-agencies-hero>
        <img
            src="{{ asset('images/agencies/hero-agencies.png') }}"
            alt=""
            class="absolute inset-0 -z-20 h-full w-full origin-top scale-[0.86] object-cover object-[58%_top] opacity-95 sm:scale-100 sm:object-[58%_center]"
            aria-hidden="true"
        >

        <div class="absolute inset-0 -z-10 bg-gs-navy/5" aria-hidden="true"></div>
        <div
            class="absolute inset-0 -z-10"
            style="background: linear-gradient(90deg, rgba(6, 42, 92, 0.20) 0%, rgba(6, 42, 92, 0.18) 28%, rgba(6, 42, 92, 0.12) 48%, rgba(6, 42, 92, 0.06) 70%, rgba(6, 42, 92, 0.02) 100%);"
            aria-hidden="true"
        ></div>

        <div class="mx-auto flex min-h-[560px] w-full max-w-[1500px] items-center justify-center px-4 pb-16 pt-7 text-center sm:min-h-[700px] sm:px-8 sm:pb-32 sm:pt-16 lg:min-h-[680px] lg:px-14 lg:pb-24 xl:px-20">
            <div class="min-w-0 max-w-[72rem]">
                <p class="inline-flex min-h-9 items-center justify-center rounded-md bg-gs-accent px-4 text-xs font-black uppercase leading-none text-white shadow-lg shadow-gs-navy/20 sm:min-h-12 sm:px-8 sm:text-lg">
                    {{ __('agencies.hero.eyebrow') }}
                </p>

                <h1 id="agencies-hero-title" class="mx-auto mt-4 max-w-[58rem] text-[2.25rem] font-black leading-[1.03] text-white min-[380px]:text-[2.5rem] sm:mt-6 sm:text-6xl lg:text-[4.75rem]">
                    {!! __('agencies.hero.title') !!}
                </h1>

                <p class="mx-auto mt-4 max-w-[22rem] text-sm font-bold leading-[1.35] text-white/90 sm:mt-7 sm:max-w-[43rem] sm:text-2xl sm:leading-[1.52]">
                    {{ __('agencies.hero.lead') }}
                </p>

                <div class="mx-auto mt-5 grid max-w-[34rem] grid-cols-4 gap-1.5 sm:mt-9 sm:max-w-[62rem] sm:gap-4 lg:max-w-[78rem] lg:gap-5" data-agencies-hero-trust>
                    @foreach ($trustItems as $item)
                        <div class="flex min-h-[4.1rem] min-w-0 flex-col items-center justify-center gap-1 rounded-lg border-2 border-white/35 bg-gs-navy/36 px-1 py-1.5 text-center text-white shadow-xl shadow-gs-navy/20 backdrop-blur-[2px] sm:min-h-[6.3rem] sm:flex-row sm:gap-4 sm:px-5 lg:justify-center">
                            <x-dynamic-component :component="$item['icon']" class="h-5 w-5 shrink-0 text-white sm:h-10 sm:w-10" aria-hidden="true" />
                            <p class="min-w-0 text-[0.5rem] font-black leading-[1.05] min-[380px]:text-[0.56rem] sm:text-lg sm:leading-tight lg:text-xl">
                                {!! $item['label'] !!}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mx-auto mt-4 grid max-w-[62rem] grid-cols-2 gap-2 sm:mt-10 sm:grid-cols-3 sm:gap-5" data-agencies-hero-actions>
                    <a href="#agence-nkolbisson" class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-md border border-white bg-white px-2 text-[0.68rem] font-black text-gs-primary shadow-xl shadow-gs-navy/25 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:min-h-16 sm:gap-3 sm:px-4 sm:text-base lg:text-lg">
                        <x-heroicon-o-arrow-down-tray class="h-4 w-4 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ __('agencies.hero.actions.nkolbisson') }}</span>
                    </a>

                    <a href="#agence-obili-scalom" class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-md border border-white bg-white px-2 text-[0.68rem] font-black text-gs-primary shadow-xl shadow-gs-navy/25 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:min-h-16 sm:gap-3 sm:px-4 sm:text-base lg:text-lg">
                        <x-heroicon-o-arrow-down-tray class="h-4 w-4 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ __('agencies.hero.actions.obili') }}</span>
                    </a>

                    <a href="{{ $bookingHref }}" class="col-span-2 inline-flex min-h-11 items-center justify-center gap-1.5 rounded-md bg-gs-accent px-2 text-[0.68rem] font-black text-white shadow-xl shadow-gs-accent/25 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:col-span-1 sm:min-h-16 sm:gap-3 sm:px-4 sm:text-base lg:text-lg">
                        <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ __('actions.book') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="gs-hero-ribbon pointer-events-none absolute inset-x-0 bottom-0 overflow-hidden" aria-hidden="true">
            <span class="gs-hero-ribbon__red"></span>
            <span class="gs-hero-ribbon__blue"></span>
            <span class="gs-hero-ribbon__white"></span>
            <span class="gs-hero-ribbon__red-left"></span>
            <span class="gs-hero-ribbon__baseline"></span>
        </div>
    </section>

    <section class="bg-white px-4 py-7 sm:px-8 sm:py-10 lg:px-16 lg:py-12 xl:px-24 2xl:px-[100px]" aria-label="{{ __('nav.agencies') }}" data-agencies-list>
        <div class="mx-auto max-w-[104rem] space-y-6 sm:space-y-8">
            @foreach ($agencyCards as $agency)
                <article id="{{ $agency['id'] }}" class="relative scroll-mt-28 overflow-hidden rounded-lg border border-gs-concrete/80 bg-white shadow-lg shadow-gs-navy/10" data-agency-card>
                    <span class="absolute bottom-8 left-0 top-8 z-10 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>

                    <div class="grid min-h-[24rem] lg:grid-cols-[0.9fr_1fr]">
                        <div class="relative z-20 flex min-w-0 flex-col justify-center px-6 py-7 pl-10 sm:px-9 sm:py-9 sm:pl-14 lg:px-12 lg:py-12 lg:pl-16">
                            <p class="inline-flex w-fit items-center gap-2 rounded-md bg-green-50 px-4 py-2 text-sm font-black text-gs-success sm:text-base">
                                <span class="h-3.5 w-3.5 rounded-full bg-gs-success" aria-hidden="true"></span>
                                {{ $agency['status'] }}
                            </p>

                            <h2 class="mt-7 text-3xl font-black leading-tight text-gs-navy sm:text-4xl lg:text-[2.65rem]">
                                {{ $agency['name'] }}
                            </h2>

                            <div class="mt-6 space-y-5 text-base font-semibold leading-relaxed text-gs-ink sm:text-lg lg:text-xl">
                                <p class="flex gap-4">
                                    <x-heroicon-s-map-pin class="mt-1 h-6 w-6 shrink-0 text-gs-grey" aria-hidden="true" />
                                    <span>{{ $agency['address'] }}</span>
                                </p>

                                <p class="flex gap-4">
                                    <x-heroicon-o-clock class="mt-1 h-6 w-6 shrink-0 text-gs-grey" aria-hidden="true" />
                                    <span>{!! $agency['hours'] !!}</span>
                                </p>

                                <p class="flex gap-4">
                                    <x-heroicon-s-phone class="mt-1 h-6 w-6 shrink-0 text-gs-grey" aria-hidden="true" />
                                    <span>{{ $agency['phone'] }}</span>
                                </p>
                            </div>

                            <div class="mt-8 grid gap-3 sm:max-w-md sm:grid-cols-2">
                                <a href="{{ $agency['whatsappHref'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-13 items-center justify-center gap-2 rounded-md border-2 border-gs-success/45 bg-white px-4 text-sm font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:border-gs-success hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-gs-success focus:ring-offset-2 sm:text-base">
                                    <svg class="h-5 w-5 shrink-0 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M7.3 19.6 3 21l1.4-4.1A8.3 8.3 0 1 1 7.3 19.6Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <path d="M8.8 8.9c.2-.5.4-.5.7-.5h.6c.2 0 .4 0 .6.5l.7 1.6c.1.3.1.5-.1.7l-.4.5c-.2.2-.2.4-.1.6.4.8 1.2 1.6 2.1 2 .2.1.4.1.6-.1l.6-.7c.2-.2.4-.2.7-.1l1.6.7c.4.2.5.4.5.6 0 .7-.5 1.5-1.1 1.8-.8.4-2.6.1-4.5-1.1-1.7-1.1-3-2.8-3.5-4.2-.5-1.2 0-2 .3-2.3Z" fill="currentColor" />
                                    </svg>
                                    <span>{{ __('actions.whatsapp') }}</span>
                                </a>

                                <a href="{{ $bookingHref }}" class="inline-flex min-h-13 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                    <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0" aria-hidden="true" />
                                    <span>{{ __('agencies.card_actions.book') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="relative min-h-[20rem] overflow-hidden border-t border-gs-concrete bg-gs-soft lg:min-h-full lg:border-l lg:border-t-0" data-agency-map data-map-zoom="16">
                            <div class="pointer-events-auto absolute left-4 top-4 z-10 max-w-[18rem] rounded-md bg-white/95 p-4 shadow-lg shadow-gs-navy/15 ring-1 ring-gs-concrete/80 sm:left-6 sm:top-6">
                                <p class="text-base font-black leading-tight text-gs-ink sm:text-lg">
                                    {{ $agency['name'] }}
                                </p>
                                <p class="mt-3 text-sm font-semibold leading-snug text-gs-ink sm:text-base">
                                    {{ $agency['mapCardAddress'] }}
                                </p>
                                <a href="{{ $agency['mapHref'] }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex text-sm font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                    {{ __('agencies.map.expand') }}
                                </a>
                            </div>

                            <iframe
                                src="{{ $agency['mapEmbed'] }}"
                                title="{{ $agency['mapTitle'] }}"
                                class="h-full min-h-[20rem] w-full"
                                data-agency-map-frame
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>

                            <div class="absolute right-4 top-1/2 z-10 flex -translate-y-1/2 flex-col overflow-hidden rounded-md bg-white shadow-lg shadow-gs-navy/15 ring-1 ring-gs-concrete/80" aria-hidden="false">
                                <button type="button" class="flex h-12 w-12 items-center justify-center text-3xl font-black leading-none text-gs-ink transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary" aria-label="{{ __('agencies.map.zoom_in') }}" data-agency-map-zoom-in>
                                    +
                                </button>
                                <span class="h-px bg-gs-concrete" aria-hidden="true"></span>
                                <button type="button" class="flex h-12 w-12 items-center justify-center text-4xl font-black leading-none text-gs-ink transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary" aria-label="{{ __('agencies.map.zoom_out') }}" data-agency-map-zoom-out>
                                    -
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
