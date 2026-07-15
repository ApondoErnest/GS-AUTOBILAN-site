@extends('layouts.app')

@section('title', __('chrome.home_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $bookingHref = route($routeLocale.'.booking', [], false);
    $trackingHref = route($routeLocale.'.tracking', [], false);
    $servicesHref = route($routeLocale.'.services', [], false);
    $tariffsHref = route($routeLocale.'.tariffs', [], false);
    $technicalInspectionHref = route($routeLocale.'.technical_inspection', [], false);
    $newsHref = route($routeLocale.'.news', [], false);
    $heroImages = [
        asset('images/homepage/hero-1.png'),
        asset('images/homepage/hero-2.png'),
        asset('images/homepage/hero-3.png'),
        asset('images/homepage/hero-4.png'),
        asset('images/homepage/hero-5.png'),
    ];
    $trustItems = trans('home.hero.trust_items');
    $agencyCards = trans('home.agencies.cards');
    $inspectionPoints = trans('home.inspection.points');
    $inspectionSteps = trans('home.inspection.steps');
    $tariffRows = trans('home.tariffs_gallery.tariffs');
    $whyItems = trans('home.tariffs_gallery.why_items');
    $galleryImages = trans('home.tariffs_gallery.gallery_images');
    $adviceArticles = trans('home.advice_cta.articles');
    $adviceCtaColumns = trans('home.advice_cta.columns');
@endphp

@section('content')
    <section class="relative isolate min-h-[640px] overflow-hidden bg-gs-navy text-white sm:min-h-[720px] lg:min-h-[760px]" aria-label="{{ __('chrome.home_aria') }}" data-hero-carousel>
        <div class="absolute inset-0 -z-20 bg-gs-navy">
            @foreach ($heroImages as $image)
                <img
                    src="{{ $image }}"
                    alt=""
                    class="gs-hero-slide absolute inset-0 h-full w-full object-cover max-sm:!bottom-auto max-sm:!h-[70%] max-sm:object-[center_top] {{ $loop->first ? 'is-active' : '' }}"
                    data-hero-slide
                    aria-hidden="true"
                >
            @endforeach
        </div>

        <div class="absolute inset-0 -z-10 bg-gs-navy/20" aria-hidden="true"></div>
        <div
            class="absolute inset-0 -z-10"
            style="background: linear-gradient(90deg, rgba(6, 42, 92, 0.78) 0%, rgba(6, 42, 92, 0.66) 30%, rgba(6, 42, 92, 0.45) 58%, rgba(6, 42, 92, 0.16) 100%);"
            aria-hidden="true"
        ></div>

        <div class="mx-auto flex min-h-[640px] w-full max-w-[1540px] items-center justify-center px-4 pb-24 pt-10 text-center sm:min-h-[720px] sm:px-8 sm:pb-32 sm:pt-16 lg:min-h-[760px] lg:px-14 xl:px-20">
            <div class="min-w-0 max-w-[82rem]">
                <p class="text-xs font-black uppercase text-gs-accent sm:text-base lg:text-lg">
                    {{ __('home.hero.eyebrow') }}
                </p>
                <div class="mx-auto mt-2 h-1 w-60 max-w-full bg-gs-accent sm:mt-3 sm:w-96" aria-hidden="true"></div>

                <h1 class="mx-auto mt-5 max-w-5xl text-[2.45rem] font-black leading-[1.06] text-white sm:mt-7 sm:text-6xl lg:text-7xl xl:text-8xl">
                    {!! __('home.hero.title') !!}
                </h1>

                <p class="mx-auto mt-5 max-w-[22rem] text-[0.95rem] font-semibold leading-[1.45] text-white/90 sm:mt-7 sm:max-w-[62rem] sm:text-2xl sm:leading-relaxed lg:text-[1.6rem]">
                    {{ __('home.hero.lead') }}
                </p>

                <div class="mt-7 flex flex-row justify-center gap-2 sm:mt-10 sm:flex-wrap sm:gap-4">
                    <a href="{{ $bookingHref }}" class="inline-flex min-h-12 flex-1 basis-0 items-center justify-center gap-2 rounded-md border border-white bg-white px-3 text-xs font-black leading-tight text-gs-primary shadow-xl shadow-gs-navy/30 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:min-h-16 sm:flex-none sm:basis-auto sm:gap-3 sm:px-8 sm:text-base">
                        <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0 sm:h-7 sm:w-7" aria-hidden="true" />
                        <span>{{ __('actions.book') }}</span>
                    </a>

                    <a href="{{ $trackingHref }}" class="inline-flex min-h-12 flex-1 basis-0 items-center justify-center gap-2 rounded-md border-2 border-white/55 bg-gs-navy/35 px-3 text-xs font-black leading-tight text-white shadow-xl shadow-gs-navy/25 transition hover:border-white hover:bg-gs-navy/60 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:min-h-16 sm:flex-none sm:basis-auto sm:gap-3 sm:px-8 sm:text-base">
                        <x-heroicon-o-clipboard-document-list class="h-5 w-5 shrink-0 sm:h-7 sm:w-7" aria-hidden="true" />
                        <span>{{ __('actions.track') }}</span>
                    </a>
                </div>

                <div class="mx-auto mt-6 grid max-w-[25rem] grid-cols-3 auto-rows-fr gap-x-2 gap-y-2 text-center sm:mt-8 sm:max-w-[42rem] sm:grid-cols-5 sm:gap-x-3 sm:gap-y-3 lg:mt-14 lg:max-w-[80rem] lg:gap-x-7 lg:text-left xl:gap-x-10">
                    @foreach ($trustItems as $item)
                        <div class="flex min-w-0 flex-col items-center justify-start gap-1.5 border-white/10 lg:flex-row lg:justify-start lg:gap-4 xl:gap-5 xl:border-r xl:pr-10 last:xl:border-r-0">
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-white/30 bg-gs-navy/35 text-white shadow-lg shadow-gs-navy/20 sm:h-10 sm:w-10 lg:h-14 lg:w-14">
                                <x-dynamic-component :component="$item['icon']" class="h-4 w-4 sm:h-5 sm:w-5 lg:h-7 lg:w-7" aria-hidden="true" />
                            </span>
                            <p class="min-w-0 text-[0.62rem] font-bold leading-[1.12] text-white/90 sm:text-xs sm:leading-tight lg:text-base lg:leading-snug">
                                {!! $item['label'] !!}
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

    <section class="bg-white px-4 py-9 sm:px-6 sm:py-10 lg:px-8 lg:py-12" aria-labelledby="home-agencies-title" data-home-agencies>
        <div class="mx-auto max-w-[104rem]">
            <div class="max-w-2xl">
                <h2 id="home-agencies-title" class="text-3xl font-black leading-tight text-gs-navy sm:text-4xl">
                    {{ __('home.agencies.title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>
                <p class="mt-4 max-w-xl text-base font-semibold leading-relaxed text-gs-grey sm:text-lg">
                    {{ __('home.agencies.copy') }}
                </p>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2 xl:gap-8">
                @foreach ($agencyCards as $agency)
                    <article class="relative isolate overflow-hidden rounded-lg border border-gs-concrete bg-white p-5 shadow-md shadow-gs-navy/10 sm:p-7">
                        <span class="absolute left-0 top-5 z-10 h-20 w-1.5 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>
                        <img
                            src="{{ asset($agency['image']) }}"
                            alt=""
                            class="pointer-events-none absolute bottom-10 right-0 z-0 w-[44%] max-w-[18rem] object-contain opacity-[0.13] sm:bottom-8 sm:w-[36%] sm:max-w-[20rem]"
                            aria-hidden="true"
                        >

                        <div class="relative z-10 flex min-w-0 gap-4 pl-2 sm:gap-5">
                            <span class="mt-1 inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full text-gs-primary">
                                <x-heroicon-s-map-pin class="h-11 w-11" aria-hidden="true" />
                            </span>
                            <div class="min-w-0">
                                <h3 class="whitespace-nowrap text-[0.95rem] font-black leading-tight text-gs-primary sm:text-2xl lg:text-[1.35rem] xl:text-[1.65rem]">
                                    {{ $agency['name'] }}
                                </h3>

                                <div class="mt-5 space-y-4 text-sm font-semibold leading-relaxed text-gs-ink sm:text-base">
                                    <p class="flex gap-3">
                                        <x-heroicon-o-clock class="mt-0.5 h-5 w-5 shrink-0 text-gs-ink-muted" aria-hidden="true" />
                                        <span>{{ $agency['address'] }}</span>
                                    </p>
                                    <p class="flex gap-3">
                                        <x-heroicon-o-clock class="mt-0.5 h-5 w-5 shrink-0 text-gs-ink-muted" aria-hidden="true" />
                                        <span>{!! $agency['hours'] !!}</span>
                                    </p>
                                    <p class="flex gap-3">
                                        <x-heroicon-o-arrow-path class="mt-0.5 h-5 w-5 shrink-0 text-gs-ink-muted" aria-hidden="true" />
                                        <span>{{ $agency['holiday'] }}</span>
                                    </p>
                                    <p class="flex gap-3">
                                        <x-heroicon-o-phone class="mt-0.5 h-5 w-5 shrink-0 text-gs-ink-muted" aria-hidden="true" />
                                        <span>{{ $agency['phone'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 mt-6 grid grid-cols-2 gap-3">
                            <a href="{{ $agency['mapHref'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-md border border-gs-primary/35 bg-white px-3 text-sm font-black text-gs-primary shadow-sm transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                <x-heroicon-o-paper-airplane class="h-5 w-5 shrink-0" aria-hidden="true" />
                                <span>{{ __('actions.directions') }}</span>
                            </a>

                            <a href="{{ $bookingHref }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-md bg-gs-primary px-3 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0" aria-hidden="true" />
                                <span>{{ __('home.agencies.book_action') }}</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gs-soft px-4 py-9 sm:px-6 sm:py-10 lg:px-8 lg:py-12" aria-labelledby="home-inspection-title" data-home-inspection>
        <div class="mx-auto grid max-w-[104rem] gap-12 lg:grid-cols-[1fr_1.05fr] lg:gap-16 xl:gap-20">
            <div>
                <h2 id="home-inspection-title" class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl lg:text-[1.85rem]">
                    {{ __('home.inspection.points_title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>

                <div class="mt-8 grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-5 lg:gap-3">
                    @foreach ($inspectionPoints as $point)
                        <div class="flex min-h-32 flex-col items-center justify-center gap-4 rounded-md bg-white p-4 text-center shadow-sm shadow-gs-navy/10 ring-1 ring-gs-concrete/70 sm:min-h-36">
                            <x-dynamic-component :component="$point['icon']" class="h-12 w-12 text-gs-primary sm:h-14 sm:w-14" aria-hidden="true" />
                            <p class="text-sm font-black leading-tight text-gs-ink sm:text-base">
                                {!! $point['label'] !!}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ $servicesHref }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md border border-gs-primary/25 bg-white px-6 text-sm font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-surface focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                        <span>{{ __('home.inspection.services_action') }}</span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl lg:text-[1.85rem]">
                    {{ __('home.inspection.process_title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>

                <ol class="relative mt-7 space-y-5 before:absolute before:bottom-8 before:left-5 before:top-6 before:w-px before:border-l before:border-dashed before:border-gs-primary/45 sm:before:left-6">
                    @foreach ($inspectionSteps as $step)
                        <li class="relative flex gap-5 sm:gap-6">
                            <span class="relative z-10 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gs-primary text-sm font-black text-white shadow-md shadow-gs-primary/25 ring-4 ring-gs-soft sm:h-12 sm:w-12 sm:text-base">
                                {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="min-w-0 pt-0.5">
                                <h3 class="text-base font-black leading-tight text-gs-primary sm:text-xl">
                                    {{ $step['title'] }}
                                </h3>
                                <p class="mt-1 text-sm font-semibold leading-relaxed text-gs-grey sm:text-base">
                                    {{ $step['copy'] }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <div class="mt-8">
                    <a href="{{ $technicalInspectionHref }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md bg-gs-primary px-6 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                        <span>{{ __('home.inspection.learn_action') }}</span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-9 sm:px-6 sm:py-10 lg:px-8 lg:py-12" aria-labelledby="home-tariffs-title" data-home-tariffs-gallery>
        <div class="mx-auto grid max-w-[104rem] gap-10 xl:grid-cols-[1.42fr_0.56fr_1.12fr] xl:gap-10">
            <div class="rounded-lg bg-gs-navy p-5 text-white shadow-xl shadow-gs-navy/15 sm:p-7">
                <h2 id="home-tariffs-title" class="text-2xl font-black leading-tight sm:text-3xl">
                    {{ __('home.tariffs_gallery.tariffs_title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>
                <p class="mt-4 text-sm font-semibold leading-relaxed text-white/75">
                    {{ __('home.tariffs_gallery.tariffs_source') }}
                </p>

                <div class="mt-5">
                    <div class="grid grid-cols-[0.72fr_2.2fr_0.95fr_0.7fr] gap-3 border-b border-white/25 pb-3 text-[0.68rem] font-black uppercase leading-tight text-white/80 sm:text-xs">
                        <span>{{ __('home.tariffs_gallery.table.category') }}</span>
                        <span>{{ __('home.tariffs_gallery.table.type') }}</span>
                        <span class="text-right">{{ __('home.tariffs_gallery.table.price') }}</span>
                        <span class="text-right">{{ __('home.tariffs_gallery.table.validity') }}</span>
                    </div>

                    <div class="divide-y divide-white/10">
                        @foreach ($tariffRows as $row)
                            <div class="grid grid-cols-[0.72fr_2.2fr_0.95fr_0.7fr] gap-3 py-3 text-xs font-bold leading-snug text-white/90 sm:text-sm">
                                <span class="text-white">{{ $row['category'] }}</span>
                                <span class="min-w-0">{{ $row['type'] }}</span>
                                <span class="whitespace-nowrap text-right text-white">{{ $row['price'] }}</span>
                                <span class="whitespace-nowrap text-right">{{ $row['validity'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 flex justify-center">
                    <a href="{{ $tariffsHref }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md border border-white/45 px-6 text-sm font-black text-white transition hover:border-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:text-base">
                        <span>{{ __('home.tariffs_gallery.tariffs_action') }}</span>
                        <x-heroicon-o-chevron-right class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>

            <div class="xl:pt-8">
                <h2 class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl">
                    {!! __('home.tariffs_gallery.why_title') !!}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>

                <div class="mt-7 divide-y divide-gs-concrete">
                    @foreach ($whyItems as $item)
                        <div class="flex items-center gap-4 py-4">
                            <x-dynamic-component :component="$item['icon']" class="h-7 w-7 shrink-0 text-gs-primary" aria-hidden="true" />
                            <p class="text-base font-bold leading-snug text-gs-grey">
                                {{ $item['label'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="xl:pt-2">
                <h2 class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl">
                    {{ __('home.tariffs_gallery.gallery_title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    @foreach ($galleryImages as $image)
                        <div class="{{ $loop->first ? 'col-span-2 aspect-[3.8/1]' : ($loop->last ? 'col-span-2 aspect-[3.4/1]' : 'aspect-[1.8/1]') }} overflow-hidden rounded-md border border-gs-concrete shadow-sm shadow-gs-navy/10">
                            <img
                                src="{{ asset($image) }}"
                                alt=""
                                class="h-full w-full object-cover"
                                loading="lazy"
                                aria-hidden="true"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-4 py-9 sm:px-6 sm:py-10 lg:px-8 lg:py-12" aria-labelledby="home-advice-title" data-home-advice-cta>
        <div class="mx-auto grid max-w-[104rem] gap-8 xl:grid-cols-[1.05fr_0.95fr] xl:items-stretch">
            <div>
                <h2 id="home-advice-title" class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl">
                    {{ __('home.advice_cta.advice_title') }}
                </h2>
                <div class="mt-3 h-1 w-12 bg-gs-accent" aria-hidden="true"></div>

                <div class="mt-5 grid gap-5 md:grid-cols-3">
                    @foreach ($adviceArticles as $article)
                        <article class="overflow-hidden rounded-lg border border-gs-concrete bg-white shadow-md shadow-gs-navy/10">
                            <a href="{{ route($routeLocale.'.article.show', ['slug' => $article['slug']], false) }}" class="group block focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                <div class="relative aspect-[2.25/1] overflow-hidden">
                                    <img
                                        src="{{ asset($article['image']) }}"
                                        alt=""
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                        loading="lazy"
                                        aria-hidden="true"
                                    >
                                    <span class="absolute left-3 top-3 rounded-sm bg-gs-accent px-2 py-1 text-xs font-black text-white shadow-sm">
                                        {{ __('home.advice_cta.tag') }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <h3 class="min-h-[3rem] text-base font-black leading-snug text-gs-ink">
                                        {{ $article['title'] }}
                                    </h3>
                                    <p class="mt-4 inline-flex items-center gap-2 text-sm font-black text-gs-primary">
                                        <span>{{ __('home.advice_cta.read_action') }}</span>
                                        <x-heroicon-o-arrow-right class="h-4 w-4 text-gs-accent transition group-hover:translate-x-0.5" aria-hidden="true" />
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="{{ $newsHref }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md border border-gs-primary/30 bg-white px-6 text-sm font-black text-gs-primary shadow-sm transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                        <span>{{ __('home.advice_cta.all_articles_action') }}</span>
                    </a>
                </div>
            </div>

            <div class="relative isolate flex h-full flex-col justify-center overflow-hidden rounded-lg bg-gs-navy p-5 text-white shadow-xl shadow-gs-navy/15 sm:p-6 lg:p-8">
                <img
                    src="{{ asset(__('home.advice_cta.background')) }}"
                    alt=""
                    class="absolute inset-0 -z-20 h-full w-full object-cover"
                    loading="lazy"
                    aria-hidden="true"
                >
                <div class="absolute inset-0 -z-10 bg-gs-navy/78" aria-hidden="true"></div>
                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-gs-navy via-gs-navy/80 to-gs-navy/45" aria-hidden="true"></div>

                <div class="max-w-3xl">
                    <h2 class="text-2xl font-black leading-tight text-white sm:text-3xl lg:text-[2.35rem]">
                        {{ __('home.advice_cta.cta_title') }}
                    </h2>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @foreach ($adviceCtaColumns as $column)
                        <div class="rounded-md border border-white/18 bg-gs-navy/42 p-3.5 shadow-lg shadow-gs-navy/15 backdrop-blur-sm">
                            <h3 class="text-sm font-black leading-snug text-white sm:text-base">
                                {{ $column['title'] }}
                            </h3>
                            <ul class="mt-3 space-y-2 text-[0.8rem] font-semibold leading-snug text-white/82 sm:text-sm">
                                @foreach ($column['items'] as $item)
                                    <li class="flex gap-2.5">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-gs-accent" aria-hidden="true"></span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
