@extends('layouts.app')

@section('title', __('about.meta_title'))

@php
    $heroStats = __('about.hero.stats');
    $principleCards = __('about.principles.cards');
    $valueChips = __('about.principles.values');
    $inspectionItems = __('about.inspection.items');
    $inspectionColumns = array_chunk($inspectionItems, 4);
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $bookingHref = route($routeLocale.'.booking', [], false);
    $contactHref = route($routeLocale.'.contact', [], false);
    $locationCards = __('about.locations.cards');
@endphp

@section('content')
    <section class="relative isolate min-h-[540px] overflow-hidden bg-gs-navy text-white sm:min-h-[660px] lg:min-h-[640px]" aria-labelledby="about-hero-title" data-about-hero>
        <img
            src="{{ asset('images/aboutpage/hero-about.png') }}"
            alt=""
            class="absolute inset-0 -z-20 h-full w-full scale-[0.84] object-cover object-[56%_top] opacity-80 sm:scale-100 sm:object-center sm:opacity-100"
            aria-hidden="true"
        >

        <div class="absolute inset-0 -z-10 bg-gs-navy/30" aria-hidden="true"></div>
        <div
            class="absolute inset-0 -z-10"
            style="background: linear-gradient(90deg, rgba(6, 42, 92, 0.98) 0%, rgba(6, 42, 92, 0.9) 31%, rgba(6, 42, 92, 0.66) 47%, rgba(6, 42, 92, 0.24) 67%, rgba(6, 42, 92, 0.02) 100%);"
            aria-hidden="true"
        ></div>

        <div class="flex min-h-[540px] w-full items-center px-4 pb-12 pt-6 sm:min-h-[660px] sm:px-8 sm:pb-20 sm:pt-12 lg:min-h-[640px] lg:px-16 lg:pb-10 lg:pt-6 xl:px-24 2xl:px-[100px]">
            <div class="max-w-[72rem]">
                <p class="inline-flex min-h-9 items-center rounded-md bg-gs-accent px-4 text-xs font-black uppercase leading-none text-white shadow-lg shadow-gs-navy/20 min-[380px]:text-sm sm:min-h-11 sm:px-7 sm:text-base lg:text-xl">
                    {{ __('about.hero.eyebrow') }}
                </p>

                <h1 id="about-hero-title" class="mt-5 max-w-[48rem] text-[2.35rem] font-black leading-[1.02] text-white min-[380px]:text-[2.55rem] sm:mt-7 sm:text-6xl lg:text-[4.65rem]">
                    {!! __('about.hero.title') !!}
                </h1>

                <p class="mt-5 max-w-[52rem] text-sm font-bold leading-[1.42] text-white/88 min-[380px]:text-[0.95rem] sm:mt-7 sm:text-2xl sm:leading-[1.55] lg:text-2xl lg:leading-[1.45]">
                    {{ __('about.hero.lead') }}
                </p>

                <div class="mt-5 grid w-full max-w-[34rem] grid-cols-3 gap-1.5 sm:mt-9 sm:max-w-[52rem] sm:gap-4 lg:flex lg:max-w-[72rem] lg:flex-row lg:flex-nowrap lg:gap-5">
                    @foreach ($heroStats as $stat)
                        <div class="flex min-h-[4.75rem] min-w-0 flex-col items-center justify-center gap-1 rounded-lg border-2 border-white/38 bg-gs-navy/36 px-1.5 py-2 text-center text-white shadow-xl shadow-gs-navy/20 backdrop-blur-[2px] sm:min-h-24 sm:flex-row sm:justify-start sm:gap-5 sm:px-6 sm:py-3 sm:text-left lg:w-auto lg:pr-7">
                            <x-dynamic-component :component="$stat['icon']" class="h-5 w-5 shrink-0 text-white min-[380px]:h-6 min-[380px]:w-6 sm:h-10 sm:w-10 lg:h-11 lg:w-11" aria-hidden="true" />
                            <p class="min-w-0 break-words text-[0.62rem] font-black leading-[1.05] min-[380px]:text-[0.68rem] sm:text-lg sm:leading-tight lg:text-xl">
                                {!! $stat['label'] !!}
                            </p>
                        </div>
                    @endforeach
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

    <section class="bg-white px-4 py-7 sm:px-8 sm:py-10 lg:px-16 lg:py-11 xl:px-24 2xl:px-[100px]" aria-labelledby="about-principles-title" data-about-orientation>
        <div class="grid max-w-[104rem] gap-7 lg:grid-cols-[0.78fr_1.35fr] lg:gap-12 xl:gap-16">
            <div class="min-w-0">
                <div class="flex gap-5 sm:gap-7">
                    <span class="mt-1 h-24 w-1.5 shrink-0 rounded-full bg-gs-accent sm:h-28" aria-hidden="true"></span>
                    <div class="min-w-0">
                        <h2 id="about-principles-title" class="text-3xl font-black leading-tight text-gs-navy sm:text-4xl lg:text-[2.6rem]">
                            {!! __('about.principles.title') !!}
                        </h2>

                        <div class="mt-6 space-y-4 text-base font-semibold leading-relaxed text-gs-ink sm:text-lg lg:text-xl">
                            @foreach (__('about.principles.copy') as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>

                        <p class="mt-6 max-w-md font-['Brush_Script_MT','Segoe_Script',cursive] text-4xl leading-tight text-gs-primary sm:text-5xl">
                            {!! __('about.principles.signature') !!}
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 lg:space-y-5">
                @foreach ($principleCards as $card)
                    <article class="relative overflow-hidden rounded-lg border border-gs-concrete/70 bg-white p-5 shadow-lg shadow-gs-navy/10 sm:p-6 lg:p-7">
                        <span class="absolute inset-y-0 left-0 w-2 bg-gs-accent" aria-hidden="true"></span>

                        <div class="grid gap-5 pl-3 sm:grid-cols-[7rem_1fr] sm:items-center sm:gap-7">
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gs-soft text-gs-primary sm:h-28 sm:w-28">
                                @if ($card['icon'] === 'target')
                                    <svg class="h-12 w-12 sm:h-16 sm:w-16" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                        <circle cx="29" cy="35" r="21" stroke="currentColor" stroke-width="4" />
                                        <circle cx="29" cy="35" r="12" stroke="currentColor" stroke-width="4" />
                                        <circle cx="29" cy="35" r="4" fill="currentColor" />
                                        <path d="M43 21 55 9M45 9h10v10" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                        <path d="m39 25 10-10" stroke="currentColor" stroke-linecap="round" stroke-width="4" />
                                    </svg>
                                @elseif ($card['icon'] === 'diamond')
                                    <svg class="h-12 w-12 sm:h-16 sm:w-16" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                        <path d="M12 22h40L32 54 12 22Z" stroke="currentColor" stroke-linejoin="round" stroke-width="4" />
                                        <path d="m20 22 8-12h8l8 12M24 22l8 32 8-32M12 22l12-12h16l12 12" stroke="currentColor" stroke-linejoin="round" stroke-width="4" />
                                    </svg>
                                @else
                                    <x-dynamic-component :component="$card['icon']" class="h-12 w-12 sm:h-16 sm:w-16" aria-hidden="true" />
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-xl font-black uppercase leading-tight text-gs-primary sm:text-2xl">
                                    {{ $card['title'] }}
                                </h3>

                                @if (isset($card['copy']))
                                    <p class="mt-3 max-w-2xl text-base font-semibold leading-relaxed text-gs-ink sm:text-xl">
                                        {{ $card['copy'] }}
                                    </p>
                                @else
                                    <div class="mt-5 grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:gap-3">
                                        @foreach ($valueChips as $value)
                                            <span class="inline-flex min-h-11 min-w-0 items-center justify-center gap-2 rounded-full border border-gs-concrete bg-gs-wall px-3 text-xs font-black text-gs-ink shadow-sm shadow-gs-navy/5 sm:px-4 sm:text-sm lg:text-base">
                                                <x-dynamic-component :component="$value['icon']" class="h-4 w-4 shrink-0 text-gs-primary sm:h-5 sm:w-5" aria-hidden="true" />
                                                <span class="truncate">{{ $value['label'] }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gs-soft px-4 py-7 sm:px-8 sm:py-10 lg:px-16 lg:py-11 xl:px-24 2xl:px-[100px]" aria-labelledby="about-inspection-title" data-about-inspection-team>
        <div class="grid max-w-[104rem] gap-6 lg:grid-cols-[0.95fr_1.05fr] lg:items-center lg:gap-10 xl:gap-12">
            <div class="overflow-hidden rounded-lg shadow-lg shadow-gs-navy/10 ring-1 ring-gs-primary/10">
                <img
                    src="{{ asset('images/aboutpage/technician-about.png') }}"
                    alt=""
                    class="h-full min-h-[18rem] w-full object-cover object-[52%_center] sm:min-h-[28rem] lg:aspect-[1.66/1] lg:min-h-0"
                    aria-hidden="true"
                >
            </div>

            <div class="min-w-0">
                <h2 id="about-inspection-title" class="max-w-3xl text-3xl font-black leading-tight text-gs-navy sm:text-4xl lg:text-[2.7rem]">
                    {!! __('about.inspection.title') !!}
                </h2>

                <div class="mt-5 max-w-4xl space-y-1 text-base font-semibold leading-relaxed text-gs-ink sm:text-lg lg:text-xl">
                    @foreach (__('about.inspection.copy') as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="mt-6 grid gap-4 lg:grid-cols-2 lg:gap-8">
                    @foreach ($inspectionColumns as $column)
                        <div @class([
                            'space-y-4',
                            'lg:border-l lg:border-gs-primary/20 lg:pl-10' => ! $loop->first,
                        ])>
                            @foreach ($column as $item)
                                <div class="flex min-w-0 items-center gap-4">
                                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-gs-primary shadow-sm shadow-gs-navy/10 ring-1 ring-gs-primary/10">
                                        <x-dynamic-component :component="$item['icon']" class="h-6 w-6" aria-hidden="true" />
                                    </span>
                                    <span class="text-base font-black leading-tight text-gs-ink sm:text-lg">
                                        {{ $item['label'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-7 sm:px-8 sm:py-10 lg:px-16 lg:py-11 xl:px-24 2xl:px-[100px]" aria-labelledby="about-locations-title" data-about-locations>
        <div class="max-w-[104rem]">
            <div class="text-center">
                <h2 id="about-locations-title" class="text-3xl font-black leading-tight text-gs-navy sm:text-4xl lg:text-[2.6rem]">
                    {{ __('about.locations.title') }}
                </h2>
                <div class="mx-auto mt-4 h-1 w-16 bg-gs-accent" aria-hidden="true"></div>
            </div>

            <div class="mt-6 grid gap-5 lg:grid-cols-3 lg:gap-6">
                @foreach ($locationCards as $card)
                    <article class="relative overflow-hidden rounded-lg border border-gs-concrete/70 bg-white p-5 shadow-lg shadow-gs-navy/10 sm:p-7">
                        @if ($card['type'] === 'agency')
                            <span class="absolute inset-y-0 left-0 w-2 bg-gs-accent" aria-hidden="true"></span>
                        @endif

                        <div class="relative z-10 pl-3">
                            <div class="flex items-start gap-4">
                                <span @class([
                                    'inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-full text-white shadow-md',
                                    'bg-gs-primary shadow-gs-primary/20' => $card['type'] === 'agency',
                                    'bg-gs-ink-muted shadow-gs-navy/15' => $card['type'] !== 'agency',
                                ])>
                                    <x-heroicon-o-building-office-2 class="h-9 w-9" aria-hidden="true" />
                                </span>

                                <h3 class="pt-1 text-2xl font-black leading-tight text-gs-primary sm:text-[1.7rem]">
                                    {!! $card['name'] !!}
                                </h3>
                            </div>

                            <div class="mt-5 space-y-4 text-base font-semibold leading-relaxed text-gs-ink sm:text-lg">
                                <p class="flex gap-4">
                                    <x-heroicon-s-map-pin class="mt-1 h-6 w-6 shrink-0 text-gs-primary" aria-hidden="true" />
                                    <span>{{ $card['address'] }}</span>
                                </p>

                                @if (isset($card['box']))
                                    <p class="flex gap-4">
                                        <x-heroicon-s-map-pin class="mt-1 h-6 w-6 shrink-0 text-gs-primary/45" aria-hidden="true" />
                                        <span>{{ $card['box'] }}</span>
                                    </p>
                                @endif

                                @if (isset($card['hours']))
                                    <p class="flex gap-4">
                                        <x-heroicon-o-clock class="mt-1 h-6 w-6 shrink-0 text-gs-primary" aria-hidden="true" />
                                        <span>
                                            {!! $card['hours'] !!}
                                            <span class="mt-1 block font-black text-gs-success">{{ $card['holiday'] }}</span>
                                        </span>
                                    </p>
                                @endif

                                <p class="flex gap-4">
                                    <x-heroicon-s-phone class="mt-1 h-6 w-6 shrink-0 text-gs-primary" aria-hidden="true" />
                                    <span>{{ $card['phone'] }}</span>
                                </p>

                                @if (isset($card['email']))
                                    <p class="flex gap-4">
                                        <x-heroicon-o-envelope class="mt-1 h-6 w-6 shrink-0 text-gs-primary" aria-hidden="true" />
                                        <span class="break-all">{{ $card['email'] }}</span>
                                    </p>
                                @endif
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                @if ($card['type'] === 'agency')
                                    <a href="{{ $card['mapHref'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-14 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                        <x-heroicon-o-paper-airplane class="h-5 w-5 shrink-0" aria-hidden="true" />
                                        <span>{{ __('actions.directions') }}</span>
                                    </a>

                                    <a href="{{ $bookingHref }}" class="inline-flex min-h-14 items-center justify-center gap-2 rounded-md bg-gs-accent px-4 text-sm font-black text-white shadow-lg shadow-gs-accent/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-gs-accent focus:ring-offset-2 sm:text-base">
                                        <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0" aria-hidden="true" />
                                        <span>{{ __('actions.book') }}</span>
                                    </a>
                                @else
                                    <a href="{{ $contactHref }}" class="inline-flex min-h-14 items-center justify-center gap-2 rounded-md bg-gs-ink-muted px-4 text-sm font-black text-white shadow-lg shadow-gs-navy/15 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:col-span-1 sm:text-base">
                                        <x-heroicon-o-envelope class="h-5 w-5 shrink-0" aria-hidden="true" />
                                        <span>{{ __('about.locations.contact_action') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
