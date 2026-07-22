@extends('layouts.app')

@section('title', __('services.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $bookingHref = route($routeLocale.'.booking', [], false);
    $technicalInspectionHref = route($routeLocale.'.technical_inspection', [], false);
    $agenciesHref = route($routeLocale.'.agencies', [], false);
    $tariffsHref = route($routeLocale.'.tariffs', [], false);
    $focusItems = __('services.hero.focus_items');
    $coreServices = __('services.architecture.core.cards');
    $vehicleProfiles = __('services.architecture.vehicles.profiles');
    $technicalChecks = __('services.architecture.technical_matrix.items');
    $decisionGate = __('services.architecture.decision_gate');
    $servicesRouteTargets = [
        'agencies' => $agenciesHref,
        'booking' => $bookingHref,
        'tariffs' => $tariffsHref,
        'technical_inspection' => $technicalInspectionHref,
    ];
@endphp

@section('content')
    <section class="relative isolate min-h-[520px] overflow-hidden bg-gs-navy text-white sm:min-h-[610px] lg:min-h-[580px]" aria-labelledby="services-hero-title" data-services-hero>
        <img
            src="{{ asset('images/servicespage/services-hero.png') }}"
            alt=""
            class="absolute inset-x-0 top-0 -z-20 h-[64%] w-full object-cover object-[58%_top] opacity-95 sm:inset-0 sm:h-full sm:object-[58%_center]"
            aria-hidden="true"
        >

        <div class="absolute inset-0 -z-10 bg-gs-navy/42" aria-hidden="true"></div>
        <div
            class="absolute inset-0 -z-10"
            style="background: radial-gradient(circle at center, rgba(6, 42, 92, 0.88) 0%, rgba(6, 42, 92, 0.76) 38%, rgba(6, 42, 92, 0.48) 70%, rgba(6, 42, 92, 0.28) 100%);"
            aria-hidden="true"
        ></div>

        <div class="mx-auto flex min-h-[520px] w-full max-w-[1500px] items-center justify-center px-4 pb-16 pt-8 text-center sm:min-h-[610px] sm:px-8 sm:pb-24 sm:pt-16 lg:min-h-[580px] lg:px-14 lg:pb-20 xl:px-20">
            <div class="min-w-0 max-w-[74rem]">
                <p class="inline-flex min-h-9 items-center justify-center rounded-md bg-gs-accent px-5 text-xs font-black uppercase leading-none text-white shadow-lg shadow-gs-navy/20 min-[380px]:text-sm sm:min-h-12 sm:px-8 sm:text-lg">
                    {{ __('services.hero.eyebrow') }}
                </p>

                <h1 id="services-hero-title" class="mx-auto mt-5 max-w-[62rem] text-[2.15rem] font-black leading-[1.04] text-white min-[380px]:text-[2.45rem] sm:mt-6 sm:text-6xl lg:text-[4.35rem]">
                    {{ __('services.hero.title') }}
                </h1>

                <p class="mx-auto mt-5 max-w-[24rem] text-sm font-bold leading-[1.45] text-white/90 min-[380px]:text-[0.95rem] sm:mt-7 sm:max-w-[54rem] sm:text-2xl sm:leading-[1.5] lg:text-[1.45rem]">
                    {{ __('services.hero.lead') }}
                </p>

                <div class="mx-auto mt-6 grid max-w-[34rem] grid-cols-2 gap-2.5 sm:mt-9 sm:max-w-[62rem] sm:grid-cols-4 sm:gap-4 lg:max-w-[74rem] lg:gap-5" data-services-hero-focus>
                    @foreach ($focusItems as $item)
                        <div class="flex min-h-[4.7rem] min-w-0 flex-col items-center justify-center gap-1.5 rounded-lg border-2 border-white/35 bg-gs-navy/38 px-2 py-2 text-center text-white shadow-xl shadow-gs-navy/20 backdrop-blur-[2px] sm:min-h-[5.9rem] sm:flex-row sm:gap-3 sm:px-4 lg:min-h-[6.2rem] lg:gap-4">
                            @if ($item['icon'] === 'car')
                                <svg class="h-6 w-6 shrink-0 text-white sm:h-9 sm:w-9 lg:h-10 lg:w-10" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                    <path d="M10 26h28l-3.7-9.3A4 4 0 0 0 30.6 14H17.4a4 4 0 0 0-3.7 2.7L10 26Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                    <path d="M7 26h34v10H7V26Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
                                    <path d="M14 36v3M34 36v3M14 30h.1M34 30h.1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                </svg>
                            @else
                                <x-dynamic-component :component="$item['icon']" class="h-6 w-6 shrink-0 text-white sm:h-9 sm:w-9 lg:h-10 lg:w-10" aria-hidden="true" />
                            @endif

                            <p class="min-w-0 text-[0.7rem] font-black leading-[1.08] min-[380px]:text-xs sm:text-base sm:leading-tight lg:text-lg">
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

    <section class="bg-white px-4 pb-6 pt-8 sm:px-8 sm:pb-8 sm:pt-12 lg:px-[100px] lg:pb-8 lg:pt-14" aria-labelledby="services-core-title" data-services-core>
        <div class="mx-auto max-w-none">
            <div>
                <h2 id="services-core-title" class="text-xl font-black uppercase leading-tight tracking-normal text-gs-bay sm:text-2xl">
                    {{ __('services.architecture.core.eyebrow') }}
                </h2>
                <div class="mt-3 h-1 w-14 rounded-full bg-gs-accent" aria-hidden="true"></div>
            </div>

            <div class="mt-5 grid gap-3 sm:gap-5 lg:grid-cols-3 lg:gap-5 xl:gap-6">
                @foreach ($coreServices as $service)
                    @php
                        $serviceHref = ($service['action_target'] ?? 'technical_inspection') === 'booking'
                            ? $bookingHref
                            : $technicalInspectionHref;
                    @endphp

                    <article id="{{ $service['id'] }}" class="relative flex min-h-full scroll-mt-28 flex-col overflow-hidden rounded-lg border border-gs-concrete/80 bg-white px-4 py-4 pl-6 shadow-md shadow-gs-navy/10 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-gs-navy/15 sm:px-7 sm:py-6 sm:pl-10 lg:px-6 lg:py-5 lg:pl-9 xl:px-7 xl:py-6 xl:pl-10" data-core-service-card>
                        <span class="absolute inset-y-0 left-0 w-1.5 bg-gs-accent sm:w-2" aria-hidden="true"></span>

                        <div class="grid grid-cols-[3.25rem_1fr] items-start gap-3 sm:grid-cols-[5.5rem_1fr] sm:gap-5 lg:grid-cols-[5rem_1fr] xl:grid-cols-[5.5rem_1fr]">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full border-2 border-gs-primary text-gs-primary sm:h-20 sm:w-20 lg:h-[4.5rem] lg:w-[4.5rem] xl:h-20 xl:w-20">
                                @if ($service['icon'] === 'car')
                                    <svg class="h-7 w-7 sm:h-12 sm:w-12 lg:h-10 lg:w-10 xl:h-12 xl:w-12" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                        <path d="M10 26h28l-3.7-9.3A4 4 0 0 0 30.6 14H17.4a4 4 0 0 0-3.7 2.7L10 26Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M7 26h34v10H7V26Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M14 36v3M34 36v3M14 30h.1M34 30h.1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                    </svg>
                                @else
                                    <x-dynamic-component :component="$service['icon']" class="h-7 w-7 sm:h-12 sm:w-12 lg:h-10 lg:w-10 xl:h-12 xl:w-12" aria-hidden="true" />
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-lg font-black leading-tight text-gs-bay sm:text-2xl lg:text-[1.35rem] xl:text-2xl">
                                    {{ $service['title'] }}
                                </h3>

                                <p class="mt-1.5 text-[0.78rem] font-semibold leading-snug text-gs-grey min-[380px]:text-[0.82rem] sm:mt-3 sm:text-base sm:leading-relaxed lg:text-[0.95rem] xl:text-base">
                                    {{ $service['summary'] }}
                                </p>
                            </div>
                        </div>

                        <ul class="mt-3 grid gap-x-3 gap-y-1.5 text-[0.76rem] font-black leading-snug text-gs-ink min-[430px]:grid-cols-2 sm:mt-5 sm:block sm:space-y-2.5 sm:text-base lg:text-sm xl:text-base">
                            @foreach ($service['points'] as $point)
                                <li class="flex gap-2 sm:gap-3">
                                    <x-heroicon-o-check-circle class="mt-px h-4 w-4 shrink-0 text-gs-primary sm:h-5 sm:w-5" aria-hidden="true" />
                                    <span>{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ $serviceHref }}" class="mt-4 inline-flex w-fit items-center gap-2 text-sm font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:mt-6 sm:gap-3 sm:text-lg lg:text-base xl:text-lg">
                            <span>{{ $service['action'] }}</span>
                            <x-heroicon-o-arrow-right class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-4 pb-8 pt-3 sm:px-8 sm:pb-10 sm:pt-4 lg:px-[100px] lg:pb-12 lg:pt-4" aria-labelledby="services-vehicles-title" data-services-vehicles>
        <div class="mx-auto max-w-none overflow-hidden rounded-2xl border border-gs-primary/10 bg-white p-3 shadow-md shadow-gs-navy/8 sm:p-5 lg:p-6" data-services-architecture-panel>
            <div data-service-vehicle-selector>
                <div>
                    <h2 id="services-vehicles-title" class="text-lg font-black uppercase leading-tight tracking-normal text-gs-bay sm:text-2xl">
                        {{ __('services.architecture.vehicles.eyebrow') }}
                    </h2>
                    <div class="mt-2 h-1 w-14 rounded-full bg-gs-accent sm:mt-3" aria-hidden="true"></div>
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2 overflow-hidden rounded-md border border-gs-primary/20 bg-white shadow-sm shadow-gs-navy/5 lg:grid-cols-4" role="tablist" aria-label="{{ __('services.architecture.vehicles.eyebrow') }}">
                        @foreach ($vehicleProfiles as $profile)
                            <button
                                type="button"
                                id="vehicle-tab-{{ $profile['id'] }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="vehicle-panel-{{ $profile['id'] }}"
                                data-vehicle-profile-tab="{{ $profile['id'] }}"
                                @class([
                                    'inline-flex min-h-11 items-center justify-center gap-2 border-gs-primary/20 px-2 text-xs font-black transition focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary min-[380px]:text-sm sm:min-h-14 sm:gap-3 sm:px-4 sm:text-base lg:min-h-14 lg:text-base xl:min-h-16 xl:text-lg',
                                    'border-gs-primary bg-gs-primary text-white shadow-md shadow-gs-primary/20' => $loop->first,
                                    'bg-gs-soft text-gs-bay hover:bg-white' => ! $loop->first,
                                    'border-r border-b lg:border-b-0' => ! $loop->last,
                                    'even:border-r-0 lg:even:border-r' => true,
                                    'min-[1024px]:border-r-0' => $loop->last,
                                    'nth-[n+3]:border-b-0 lg:nth-[n+3]:border-b-0' => true,
                                ])
                            >
                                @if ($profile['icon'] === 'car')
                                    <svg class="h-5 w-5 shrink-0 sm:h-6 sm:w-6 lg:h-7 lg:w-7" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                        <path d="M10 26h28l-3.7-9.3A4 4 0 0 0 30.6 14H17.4a4 4 0 0 0-3.7 2.7L10 26Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M7 26h34v10H7V26Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M14 36v3M34 36v3M14 30h.1M34 30h.1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                    </svg>
                                @elseif ($profile['icon'] === 'taxi')
                                    <svg class="h-5 w-5 shrink-0 sm:h-6 sm:w-6 lg:h-7 lg:w-7" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                        <path d="M17 14h14l1 6H16l1-6Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M10 28h28l-3.5-8.2a4 4 0 0 0-3.7-2.4H17.2a4 4 0 0 0-3.7 2.4L10 28Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M7 28h34v9H7v-9Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
                                        <path d="M14 37v3M34 37v3M14 32h.1M34 32h.1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                    </svg>
                                @else
                                    <x-dynamic-component :component="$profile['icon']" class="h-5 w-5 shrink-0 sm:h-6 sm:w-6 lg:h-7 lg:w-7" aria-hidden="true" />
                                @endif
                                <span>{{ $profile['tab'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-hidden rounded-b-lg border border-t-0 border-gs-primary/10 bg-white">
                    @foreach ($vehicleProfiles as $profile)
                        <article
                            id="vehicle-panel-{{ $profile['id'] }}"
                            role="tabpanel"
                            aria-labelledby="vehicle-tab-{{ $profile['id'] }}"
                            data-vehicle-profile-panel="{{ $profile['id'] }}"
                            @class([
                                'grid gap-4 p-3 sm:p-5 lg:grid-cols-[0.72fr_0.88fr_0.62fr] lg:items-center lg:gap-6 lg:p-6 xl:gap-8',
                                'hidden' => ! $loop->first,
                            ])
                        >
                        <div class="flex min-h-[8.25rem] items-center justify-center sm:min-h-[15rem] lg:min-h-[16rem] xl:min-h-[18rem]">
                            <img
                                src="{{ asset($profile['image']) }}"
                                alt="{{ $profile['image_alt'] }}"
                                class="max-h-[8.75rem] w-full object-contain sm:max-h-[17rem] lg:max-h-[17rem] xl:max-h-[20rem]"
                            >
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-xl font-black leading-tight text-gs-ink sm:text-3xl lg:text-[1.55rem] xl:text-[1.75rem]">
                                {{ $profile['title'] }}
                            </h3>
                            <p class="mt-2 text-sm font-semibold leading-snug text-gs-ink sm:text-base sm:leading-relaxed lg:text-sm xl:text-base">
                                {{ $profile['copy'] }}
                            </p>

                            <div class="mt-4 grid gap-3 min-[480px]:grid-cols-2 lg:block lg:space-y-3">
                                @foreach ($profile['details'] as $detail)
                                    <div class="flex gap-3">
                                        <x-dynamic-component :component="$detail['icon']" class="mt-0.5 h-5 w-5 shrink-0 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        <p class="min-w-0 text-sm font-semibold leading-snug text-gs-grey sm:text-base lg:text-sm xl:text-base">
                                            <span class="block">{{ $detail['label'] }}</span>
                                            <strong class="block font-black text-gs-ink">{{ $detail['value'] }}</strong>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <aside class="rounded-lg border border-gs-primary/10 bg-gs-soft/70 p-4 shadow-sm shadow-gs-navy/5 sm:p-5" aria-label="{{ $profile['notice_title'] }}">
                            <h4 class="text-xl font-black leading-tight text-gs-bay sm:text-2xl lg:text-xl xl:text-2xl">
                                {{ $profile['notice_title'] }}
                            </h4>
                            <p class="mt-2 text-sm font-black leading-snug text-gs-primary sm:text-base lg:text-sm xl:text-base">
                                {{ $profile['notice_copy'] }}
                            </p>

                            <ul class="mt-4 grid gap-2 text-sm font-semibold leading-snug text-gs-ink min-[480px]:grid-cols-2 lg:block lg:space-y-2 lg:text-sm xl:text-base">
                                @foreach ($profile['notice_items'] as $item)
                                    <li class="flex gap-2.5">
                                        <x-heroicon-o-check class="mt-0.5 h-4 w-4 shrink-0 stroke-[3] text-gs-primary sm:h-5 sm:w-5" aria-hidden="true" />
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ $bookingHref }}" class="mt-4 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                                <span>{{ __('actions.book') }}</span>
                                <x-heroicon-o-arrow-right class="ml-auto h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                            </a>

                            <a href="{{ $technicalInspectionHref }}" class="mt-3 inline-flex items-center gap-2 text-sm font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                <span>{{ __('services.architecture.vehicles.conditions_action') }}</span>
                                <x-heroicon-o-arrow-right class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                            </a>
                        </aside>
                    </article>
                @endforeach
            </div>
        </div>

            <div class="mt-5 border-t border-gs-concrete/80 pt-5" aria-labelledby="services-technical-title" data-services-technical-matrix>
            <div>
                <h2 id="services-technical-title" class="text-lg font-black uppercase leading-tight tracking-normal text-gs-bay sm:text-2xl">
                    {{ __('services.architecture.technical_matrix.title') }}
                </h2>
                <p class="mt-2 text-sm font-bold leading-relaxed text-gs-grey sm:text-base">
                    {{ __('services.architecture.technical_matrix.lead') }}
                </p>
            </div>

            <div class="mt-5 grid gap-3 min-[700px]:grid-cols-2 xl:grid-cols-4">
                @foreach ($technicalChecks as $check)
                    <article class="grid min-h-32 grid-cols-[4rem_1fr] items-start gap-3 rounded-lg border border-gs-concrete/80 bg-white p-4 shadow-sm shadow-gs-navy/8 transition hover:-translate-y-0.5 hover:shadow-md hover:shadow-gs-navy/12 sm:min-h-36 sm:grid-cols-[4.75rem_1fr] sm:gap-4 sm:p-5">
                        <x-icons.inspection :name="$check['icon']" class="h-14 w-14 text-gs-primary sm:h-16 sm:w-16" />

                        <div class="min-w-0">
                            <h3 class="text-base font-black leading-tight text-gs-bay sm:text-lg">
                                {{ $loop->iteration }}. {{ $check['title'] }}
                            </h3>
                            <p class="mt-2 text-sm font-semibold leading-relaxed text-gs-grey sm:text-base">
                                {{ $check['copy'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-[1fr_0.98fr]" data-services-decision-gate>
                <div class="rounded-lg border border-gs-primary/10 bg-gs-soft/40 p-5 shadow-sm shadow-gs-navy/5 sm:p-6">
                    <h2 class="text-2xl font-black leading-tight text-gs-bay sm:text-3xl lg:text-[1.75rem]">
                        {{ $decisionGate['title'] }}
                    </h2>

                    <div class="mt-5 divide-y divide-gs-concrete/80">
                        @foreach ($decisionGate['routes'] as $route)
                            <a href="{{ $servicesRouteTargets[$route['target']] }}" class="grid min-h-12 grid-cols-[1fr_auto] items-center gap-3 py-3 text-sm font-bold text-gs-ink transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:grid-cols-[1fr_2rem_0.72fr] sm:text-base">
                                <span>{{ $route['intent'] }}</span>
                                <x-heroicon-o-arrow-right class="h-5 w-5 shrink-0 text-gs-primary" aria-hidden="true" />
                                <strong class="col-span-2 font-black text-gs-primary sm:col-span-1">
                                    {{ $route['result'] }}
                                </strong>
                            </a>
                        @endforeach
                    </div>
                </div>

                <aside class="overflow-hidden rounded-lg bg-gs-navy p-5 text-white shadow-lg shadow-gs-navy/20 ring-1 ring-gs-primary/20 sm:p-6" aria-label="{{ $decisionGate['cta']['title'] }}">
                    <span class="block h-1 w-full rounded-full bg-gs-accent" aria-hidden="true"></span>

                    <h2 class="mt-5 text-2xl font-black leading-tight sm:text-3xl lg:text-[1.85rem]">
                        {{ $decisionGate['cta']['title'] }}
                    </h2>
                    <p class="mt-2 text-sm font-bold leading-relaxed text-white/80 sm:text-base">
                        {{ $decisionGate['cta']['lead'] }}
                    </p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ($decisionGate['cta']['actions'] as $action)
                            <a href="{{ $servicesRouteTargets[$action['target']] }}" class="inline-flex min-h-12 items-center gap-3 rounded-md bg-white px-4 text-sm font-black text-gs-primary shadow-sm shadow-gs-navy/15 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:text-base">
                                <x-dynamic-component :component="$action['icon']" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    <p class="mt-5 flex gap-3 text-sm font-bold leading-relaxed text-white/82 sm:text-base">
                        <x-heroicon-o-information-circle class="mt-0.5 h-6 w-6 shrink-0 text-white/80" aria-hidden="true" />
                        <span>{{ $decisionGate['cta']['notice'] }}</span>
                    </p>
                </aside>
            </div>
        </div>
    </section>
@endsection
