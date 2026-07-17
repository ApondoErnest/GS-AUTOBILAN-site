@extends('layouts.app')

@section('title', __('booking.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $command = trans('booking.command');
    $ticketFields = $command['ticket']['fields'];
    $whatsappHref = 'https://wa.me/237678844791?text='.rawurlencode($command['fast_pass']['message']);
    $callHref = 'tel:+237678844791';
    $homeHref = route($routeLocale.'.home', [], false);
    $trackingHref = route($routeLocale.'.tracking', [], false);
    $agenciesHref = route($routeLocale.'.agencies', [], false);
    $today = now()->toDateString();
@endphp

@section('content')
    <section class="bg-gs-wall px-3 py-3 sm:px-6 sm:py-4 lg:px-32" aria-labelledby="booking-hero-title" data-booking-hero>
        <div class="mx-auto max-w-[122rem] overflow-hidden rounded-xl bg-gs-navy px-4 py-4 text-white shadow-xl shadow-gs-navy/20 sm:px-8 sm:py-5 lg:px-12 lg:py-5" style="background: radial-gradient(circle at 82% 24%, rgba(20, 93, 179, 0.72) 0%, rgba(11, 58, 117, 0.84) 31%, rgba(6, 42, 92, 0.98) 66%), linear-gradient(135deg, #062a5c 0%, #0b3a75 54%, #145db3 100%);">
            <div class="max-w-[112rem]">
                <p class="inline-flex min-h-7 items-center rounded-md bg-gs-accent px-3 text-[0.65rem] font-black uppercase leading-none text-white shadow-md shadow-gs-navy/20 sm:min-h-8 sm:px-4 sm:text-sm lg:text-base">
                    {{ __('booking.hero.eyebrow') }}
                </p>

                <h1 id="booking-hero-title" class="mt-2 whitespace-nowrap text-[0.75rem] font-black leading-tight text-white min-[390px]:text-sm sm:text-3xl lg:text-[2.5rem]">
                    {!! __('booking.hero.title') !!}
                </h1>

                <p class="mt-1 max-w-[44rem] text-[0.64rem] font-medium leading-snug text-white/95 min-[390px]:text-[0.7rem] sm:text-base lg:max-w-[64rem] lg:text-lg">
                    {!! __('booking.hero.lead') !!}
                </p>

                <div class="mt-3 flex items-center gap-3 rounded-md border border-gs-warning bg-yellow-50 px-3 py-2 text-gs-ink shadow-lg shadow-gs-navy/15 sm:gap-4 sm:px-5 sm:py-3 lg:mt-3 lg:px-4 lg:py-2" data-booking-hero-notice>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gs-warning text-gs-navy shadow-sm sm:h-11 sm:w-11 lg:h-10 lg:w-10" aria-hidden="true">
                        <x-heroicon-o-exclamation-triangle class="h-6 w-6 sm:h-7 sm:w-7 lg:h-6 lg:w-6" />
                    </span>

                    <p class="text-[0.62rem] font-medium leading-snug min-[390px]:text-xs sm:text-sm lg:text-sm">
                        <strong class="font-black">{{ __('booking.hero.notice.label') }} :</strong>
                        {{ __('booking.hero.notice.body') }}
                        {{ __('booking.hero.notice.confirmation') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-3 pb-24 pt-3 sm:px-6 sm:pb-12 lg:px-16 lg:pt-3 xl:px-32 2xl:px-64" aria-labelledby="booking-command-title" data-booking-intake>
        <h2 id="booking-command-title" class="sr-only">GS Smart Inspection Booking</h2>

        <div class="mx-auto max-w-[1120px]">
            <div class="grid gap-3 lg:grid-cols-[17rem_minmax(0,1fr)] lg:items-start">
                <aside class="hidden space-y-3 lg:sticky lg:top-5 lg:block" aria-label="{{ $command['ticket']['title'] }}">
                    <article class="overflow-hidden rounded-lg border border-gs-concrete bg-white shadow-lg shadow-gs-navy/8" data-booking-ticket>
                        <div class="flex items-center gap-2.5 border-b border-gs-concrete px-4 py-3">
                            <x-heroicon-o-ticket class="h-5 w-5 text-gs-primary" aria-hidden="true" />
                            <h3 class="text-xs font-black uppercase text-gs-primary">{{ $command['ticket']['title'] }}</h3>
                        </div>

                        <div class="space-y-3 px-4 py-4">
                            @foreach ($ticketFields as $field => $label)
                                <div class="grid grid-cols-[1.15rem_1fr] gap-2.5">
                                    @switch($field)
                                        @case('agency')
                                            <x-heroicon-o-map-pin class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @case('service')
                                            <x-heroicon-o-clipboard-document-list class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @case('vehicle')
                                            <x-heroicon-o-truck class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @case('registration')
                                            <x-heroicon-o-identification class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @case('date')
                                            <x-heroicon-o-calendar-days class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @case('period')
                                            <x-heroicon-o-clock class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                            @break
                                        @default
                                            <x-heroicon-o-phone class="mt-0.5 h-[1.125rem] w-[1.125rem] text-gs-grey" aria-hidden="true" />
                                    @endswitch

                                    <div>
                                        <p class="text-[0.68rem] font-black leading-tight text-gs-ink">{{ $label }}</p>
                                        <p class="mt-0.5 inline-flex items-center gap-1 text-xs font-bold leading-tight text-gs-primary">
                                            <x-heroicon-o-check-circle class="hidden h-3.5 w-3.5 text-gs-primary" aria-hidden="true" data-ticket-check="{{ $field }}" />
                                            <span data-ticket-field="{{ $field }}">{{ $command['ticket']['empty'] }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            <div class="border-t border-dashed border-gs-primary/35 pt-4">
                                <p class="flex items-center justify-between text-[0.68rem] font-bold text-gs-grey">
                                    <span>{{ $command['ticket']['reference'] }}</span>
                                    <span class="tracking-[0.22em]" data-ticket-reference>{{ $command['ticket']['reference_pending'] }}</span>
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-lg border border-gs-concrete bg-white p-4 shadow-lg shadow-gs-navy/8">
                        <div class="flex items-center gap-2.5">
                            <x-heroicon-o-clipboard-document-list class="h-5 w-5 text-gs-primary" aria-hidden="true" />
                            <h3 class="text-xs font-black uppercase text-gs-primary">{{ $command['documents']['title'] }}</h3>
                        </div>

                        <ul class="mt-3 space-y-1.5 text-xs font-semibold leading-snug text-gs-ink">
                            @foreach ($command['documents']['items'] as $item)
                                <li class="flex gap-2">
                                    <x-heroicon-o-check-circle class="mt-px h-3.5 w-3.5 shrink-0 text-gs-success" aria-hidden="true" />
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <p class="mt-3 rounded-md bg-gs-soft p-2.5 text-[0.68rem] font-semibold leading-snug text-gs-primary">
                            {{ $command['documents']['note'] }}
                        </p>
                    </article>

                    <article class="rounded-lg border border-gs-concrete bg-white p-4 shadow-lg shadow-gs-navy/8">
                        <div class="flex items-center gap-2.5">
                            <x-heroicon-o-shield-check class="h-5 w-5 text-gs-primary" aria-hidden="true" />
                            <h3 class="text-xs font-black uppercase text-gs-primary">{{ $command['help']['title'] }}</h3>
                        </div>
                        <p class="mt-2 text-xs font-semibold leading-snug text-gs-ink">{{ $command['help']['body'] }}</p>
                        <div class="mt-3 space-y-2">
                            <a href="{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" class="flex min-h-10 items-center justify-center gap-2 rounded-md bg-gs-success px-3 text-xs font-black text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-gs-success focus:ring-offset-2">
                                <x-heroicon-o-paper-airplane class="h-4 w-4" aria-hidden="true" />
                                {{ $command['help']['whatsapp'] }}
                            </a>
                            <a href="{{ $callHref }}" class="flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-primary px-3 text-xs font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                <x-heroicon-o-phone class="h-4 w-4" aria-hidden="true" />
                                {{ $command['help']['call'] }}
                            </a>
                            <a href="{{ $agenciesHref }}" class="inline-flex min-h-8 items-center gap-1 text-xs font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                {{ $command['help']['agencies'] }}
                                <x-heroicon-o-arrow-right class="h-4 w-4" aria-hidden="true" />
                            </a>
                        </div>
                    </article>
                </aside>

                <div class="min-w-0 space-y-3" data-booking-workspace>
                    <nav class="rounded-lg bg-gs-wall px-1 py-1.5 sm:px-3" aria-label="Progression de la demande">
                        <ol class="grid grid-cols-3 items-center gap-1.5">
                            @foreach ($command['steps'] as $index => $step)
                                <li class="relative">
                                    @if (! $loop->last)
                                        <span class="pointer-events-none absolute left-[calc(50%+1.5rem)] right-[calc(-50%+1.5rem)] top-4 hidden h-px bg-gs-concrete sm:block" aria-hidden="true"></span>
                                    @endif

                                    <button type="button" class="relative z-10 flex w-full min-w-0 flex-col items-center gap-1.5 text-center text-[0.6rem] font-black text-gs-ink-muted sm:flex-row sm:justify-center sm:text-xs" data-booking-step-trigger="{{ $index + 1 }}">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gs-concrete text-xs font-black text-gs-grey transition" data-booking-step-dot>{{ $step['number'] }}</span>
                                        <span class="truncate sm:whitespace-nowrap">{{ $step['label'] }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ol>
                    </nav>

                    <form class="rounded-lg border border-gs-concrete bg-white p-3 shadow-xl shadow-gs-navy/8 sm:p-5 lg:p-5" data-booking-form novalidate>
                        <section data-booking-step-panel="1" aria-labelledby="booking-step-1-title">
                            <div class="flex items-center gap-2.5">
                                <x-heroicon-s-map-pin class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                <h3 id="booking-step-1-title" class="text-sm font-black uppercase text-gs-primary sm:text-base">1. {{ $command['step1']['agency_title'] }}</h3>
                            </div>

                            <div class="mt-4 grid gap-3 lg:grid-cols-2">
                                @foreach ($command['step1']['agencies'] as $agency)
                                    <label class="relative flex min-h-40 cursor-pointer gap-3 rounded-lg border border-gs-concrete bg-white p-4 shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft/50" data-choice-card>
                                        <input type="radio" name="agency" value="{{ $agency['slug'] }}" class="sr-only" required data-ticket-input data-ticket-target="agency" data-summary-label="{{ $agency['name'] }}" data-agency-slug="{{ $agency['slug'] }}">
                                        <span class="hidden absolute inset-y-4 left-0 w-1.5 rounded-r-sm bg-gs-accent" aria-hidden="true" data-choice-band></span>
                                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gs-soft text-gs-navy">
                                            <svg class="h-9 w-9" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                <path d="M7 41V20h10v21M17 41V12h14v29M31 41V18h10v23" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12 25h2M12 31h2M12 37h2M22 18h4M22 24h4M22 30h4M22 36h4M36 24h2M36 30h2M36 36h2M20 12l4-5 4 5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block text-lg font-black leading-tight text-gs-primary">{{ $agency['name'] }}</span>
                                            <span class="mt-2 block text-xs font-semibold leading-snug text-gs-ink">{{ $agency['address'] }}</span>
                                            <span class="mt-3 flex gap-2 text-xs font-bold leading-snug text-gs-ink">
                                                <x-heroicon-o-clock class="mt-px h-4 w-4 shrink-0 text-gs-grey" aria-hidden="true" />
                                                <span>
                                                    {{ $agency['hours'] }}
                                                    @if ($agency['sunday'])
                                                        <br>{{ $agency['sunday'] }}
                                                    @endif
                                                </span>
                                            </span>
                                            <span class="mt-3 flex items-center gap-2 text-xs font-black text-gs-success">
                                                <span class="h-2.5 w-2.5 rounded-full bg-gs-success" aria-hidden="true"></span>
                                                {{ $agency['holiday'] }}
                                            </span>
                                            <span class="mt-3 hidden items-center gap-1.5 text-xs font-black text-gs-primary" data-selected-label>
                                                <x-heroicon-o-check-circle class="h-4 w-4" aria-hidden="true" />
                                                {{ $command['step1']['selected_agency'] }}
                                            </span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-6 flex items-center gap-2.5">
                                <x-heroicon-o-wrench-screwdriver class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                <h3 class="text-sm font-black uppercase text-gs-primary sm:text-base">2. {{ $command['step1']['service_title'] }}</h3>
                            </div>

                            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach ($command['step1']['services'] as $service)
                                    <label class="relative min-h-32 cursor-pointer rounded-lg border border-gs-concrete bg-white p-4 text-center shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft/50" data-choice-card>
                                        <input type="radio" name="service_type" value="{{ $service['slug'] }}" class="sr-only" required data-ticket-input data-ticket-target="service" data-summary-label="{{ $service['name'] }}">
                                        <span class="absolute right-3 top-3 hidden text-gs-primary" data-choice-check>
                                            <x-heroicon-s-check-circle class="h-6 w-6" aria-hidden="true" />
                                        </span>
                                        <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gs-soft text-gs-navy">
                                            @switch($service['icon'])
                                                @case('car')
                                                    <svg class="h-7 w-7" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M10 28 14 18c.7-1.7 2.1-2.8 3.9-2.8h12.2c1.8 0 3.2 1.1 3.9 2.8l4 10" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8 28h32v9H8v-9Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M14 37v3M34 37v3M15 32h2M31 32h2M17 24h14" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('arrow-path')
                                                    <x-heroicon-o-arrow-path class="h-7 w-7" aria-hidden="true" />
                                                    @break
                                                @case('document')
                                                    <x-heroicon-o-document-text class="h-7 w-7" aria-hidden="true" />
                                                    @break
                                                @case('information')
                                                    <x-heroicon-o-information-circle class="h-7 w-7" aria-hidden="true" />
                                                    @break
                                            @endswitch
                                        </span>
                                        <span class="mt-3 block text-[0.95rem] font-black leading-tight text-gs-primary">{{ $service['name'] }}</span>
                                        <span class="mt-1.5 block text-xs font-semibold leading-snug text-gs-ink">{{ $service['description'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-5 flex justify-center">
                                <button type="button" class="inline-flex min-h-11 w-full max-w-sm items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-sm" data-booking-next>
                                    {{ $command['step1']['continue'] }}
                                    <x-heroicon-o-arrow-right class="h-4 w-4" aria-hidden="true" />
                                </button>
                            </div>
                        </section>

                        <section class="hidden" data-booking-step-panel="2" aria-labelledby="booking-step-2-title">
                            <div class="flex items-center gap-2.5">
                                <x-heroicon-o-truck class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                <h3 id="booking-step-2-title" class="text-sm font-black uppercase text-gs-primary sm:text-base">2. {{ $command['step2']['title'] }}</h3>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-4">
                                @foreach ($command['step2']['categories'] as $category)
                                    <label class="cursor-pointer rounded-lg border border-gs-concrete bg-white p-3 text-center shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft/50" data-choice-card>
                                        <input type="radio" name="vehicle_category" value="{{ $category['label'] }}" class="sr-only" required data-ticket-input data-ticket-target="vehicle" data-summary-label="{{ $category['label'] }}">
                                        <span class="mx-auto flex h-9 w-9 items-center justify-center rounded-full bg-gs-soft text-gs-navy">
                                            @switch($category['icon'])
                                                @case('car')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M10 29 14 20c.6-1.5 1.9-2.5 3.5-2.5h13c1.6 0 2.9 1 3.5 2.5l4 9" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8 29h32v8H8v-8Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M14 37v3M34 37v3M15 33h2M31 33h2M17 25h14" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('van')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M7 17h23v19H7V17Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M30 24h6l5 6v6H30V24Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M14 39a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM34 39a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12 22h10" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('taxi')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M18 16h12l2 5H16l2-5Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M9 30 13 21h22l4 9v7H9v-7Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M15 40v-3M33 40v-3M15 32h2M31 32h2M20 12h8" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('student-car')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M9 30 13 21h22l4 9v7H9v-7Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M15 40v-3M33 40v-3M15 32h2M31 32h2M17 25h14" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M16 13h16M20 13v6M28 13v6" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('bus')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M10 10h28c2 0 4 2 4 4v20c0 2-2 4-4 4H10c-2 0-4-2-4-4V14c0-2 2-4 4-4Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M12 17h24M12 25h24M15 41v-3M33 41v-3M14 32h3M31 32h3" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @case('heavy-truck')
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M5 18h25v17H5V18Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M30 23h8l5 6v6H30V23Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M13 39a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM35 39a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM10 23h14" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    @break
                                                @default
                                                    <svg class="h-6 w-6" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                                                        <path d="M16 35h16M12 24h24M17 13h14l5 11-4 11H16l-4-11 5-11Z" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M19 40v-5M29 40v-5" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" />
                                                    </svg>
                                            @endswitch
                                        </span>
                                        <span class="mt-2 block text-xs font-black leading-tight text-gs-primary">{{ $category['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <label class="sm:col-span-2">
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step2']['fields']['registration'] }}</span>
                                    <input type="text" name="vehicle_registration" autocomplete="off" class="mt-1.5 h-12 w-full rounded-md border-2 border-gs-navy bg-white px-4 text-center text-lg font-black uppercase tracking-[0.2em] text-gs-navy shadow-inner shadow-gs-concrete focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" required data-ticket-input data-ticket-target="registration" placeholder="CE 123 AB">
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step2']['fields']['brand'] }}</span>
                                    <input type="text" name="vehicle_brand" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step2']['fields']['model'] }}</span>
                                    <input type="text" name="vehicle_model" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step2']['fields']['year'] }}</span>
                                    <input type="number" name="vehicle_year" min="1950" max="{{ now()->year + 1 }}" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step2']['fields']['observation'] }}</span>
                                    <input type="text" name="customer_message" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                </label>
                            </div>

                            <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:justify-between">
                                <button type="button" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-primary px-4 text-xs font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" data-booking-prev>{{ $command['step2']['back'] }}</button>
                                <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" data-booking-next>
                                    {{ $command['step2']['continue'] }}
                                    <x-heroicon-o-arrow-right class="h-4 w-4" aria-hidden="true" />
                                </button>
                            </div>
                        </section>

                        <section class="hidden" data-booking-step-panel="3" aria-labelledby="booking-step-3-title">
                            <div class="flex items-center gap-2.5">
                                <x-heroicon-o-user class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                <h3 id="booking-step-3-title" class="text-sm font-black uppercase text-gs-primary sm:text-base">3. {{ $command['step3']['title'] }}</h3>
                            </div>

                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="relative" data-booking-date-picker data-min-date="{{ $today }}" data-calendar-locale="{{ $routeLocale === 'en' ? 'en-US' : 'fr-FR' }}" data-calendar-placeholder="{{ $command['step3']['calendar']['placeholder'] }}" data-calendar-closed-label="{{ $command['step3']['calendar']['closed'] }}">
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['date'] }}</span>
                                    <input type="hidden" name="preferred_date" data-ticket-input data-ticket-target="date">
                                    <button type="button" class="mt-1.5 flex h-10 w-full items-center justify-between rounded-md border border-gs-concrete bg-white px-3 text-left text-sm font-black text-gs-ink shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" data-booking-date-display aria-haspopup="dialog" aria-expanded="false">
                                        <span class="truncate text-gs-grey" data-booking-date-label>{{ $command['step3']['calendar']['placeholder'] }}</span>
                                        <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-gs-primary" aria-hidden="true" />
                                    </button>

                                    <div class="absolute left-0 z-30 mt-2 hidden w-full min-w-[18rem] max-w-[22rem] rounded-xl border border-gs-primary/20 bg-white p-3 shadow-2xl shadow-gs-navy/20 ring-1 ring-gs-primary/10" data-booking-calendar role="dialog" aria-label="{{ $command['step3']['calendar']['label'] }}">
                                        <div class="flex items-center justify-between rounded-lg bg-gs-navy px-2.5 py-2 text-white">
                                            <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-white/80 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/70 disabled:cursor-not-allowed disabled:opacity-35" data-calendar-prev aria-label="{{ $command['step3']['calendar']['previous'] }}">
                                                <x-heroicon-o-chevron-left class="h-4 w-4" aria-hidden="true" />
                                            </button>
                                            <p class="text-sm font-black capitalize tracking-normal" data-calendar-title></p>
                                            <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-white/80 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/70" data-calendar-next aria-label="{{ $command['step3']['calendar']['next'] }}">
                                                <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
                                            </button>
                                        </div>

                                        <div class="mt-3 grid grid-cols-7 gap-1 text-center text-[0.64rem] font-black uppercase text-gs-grey" data-calendar-weekdays></div>
                                        <div class="mt-1.5 grid grid-cols-7 gap-1" data-calendar-grid></div>

                                        <div class="mt-3 flex items-center justify-between gap-2 border-t border-gs-concrete pt-3">
                                            <button type="button" class="inline-flex h-8 items-center rounded-md border border-gs-primary/30 px-3 text-xs font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary/20 disabled:cursor-not-allowed disabled:opacity-45" data-calendar-today>{{ $command['step3']['calendar']['today'] }}</button>
                                            <button type="button" class="inline-flex h-8 items-center rounded-md px-3 text-xs font-black text-gs-grey transition hover:bg-gs-concrete/40 focus:outline-none focus:ring-2 focus:ring-gs-primary/20" data-calendar-clear>{{ $command['step3']['calendar']['clear'] }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs font-black text-gs-ink">{{ $command['step3']['period_title'] }}</p>
                                    <div class="mt-1.5 grid gap-1.5" data-period-group>
                                        @foreach ($command['step3']['periods'] as $period)
                                            <label class="cursor-pointer rounded-md border border-gs-concrete bg-white px-3 py-2 shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft/50" data-choice-card data-period-option>
                                                <input type="radio" name="preferred_time_slot" value="{{ $period['label'] }} — {{ $period['time'] }}" class="sr-only" required data-ticket-input data-ticket-target="period" data-summary-label="{{ $period['label'] }} — {{ $period['time'] }}">
                                                <span class="block text-xs font-black text-gs-primary">{{ $period['label'] }}</span>
                                                <span class="block text-xs font-bold text-gs-ink" data-period-time data-default-time="{{ $period['time'] }}" data-obili-sunday-time="{{ $period['sunday_time'] }}">{{ $period['time'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <p class="hidden rounded-md bg-gs-accent-soft p-2.5 text-xs font-bold text-gs-danger sm:col-span-2" data-closed-warning>
                                    {{ $command['step3']['closed_warning'] }}
                                </p>

                                <p class="rounded-md bg-gs-soft p-2.5 text-xs font-bold text-gs-primary sm:col-span-2">
                                    {{ $command['step3']['preference_note'] }}
                                </p>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['name'] }}</span>
                                    <input type="text" name="customer_name" autocomplete="name" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" required>
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['phone'] }}</span>
                                    <input type="tel" name="phone" autocomplete="tel" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" required>
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['whatsapp'] }}</span>
                                    <input type="tel" name="whatsapp" autocomplete="tel" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                    <span class="mt-1.5 block text-[0.68rem] font-bold leading-snug text-gs-primary">{{ $command['step3']['whatsapp_note'] }}</span>
                                </label>

                                <label>
                                    <span class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['email'] }}</span>
                                    <input type="email" name="email" autocomplete="email" class="mt-1.5 h-10 w-full rounded-md border border-gs-concrete px-3 text-sm font-semibold text-gs-ink focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                                </label>
                            </div>

                            <div class="mt-5">
                                <p class="text-xs font-black text-gs-ink">{{ $command['step3']['fields']['contact_mode'] }}</p>
                                <div class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-4">
                                    @foreach ($command['step3']['contact_modes'] as $mode)
                                        <label class="cursor-pointer rounded-md border border-gs-concrete bg-white px-2.5 py-2.5 text-center text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft/50" data-choice-card>
                                            <input type="radio" name="contact_mode" value="{{ $mode }}" class="sr-only" required data-ticket-input data-ticket-target="contact" data-summary-label="{{ $mode }}">
                                            {{ $mode }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-5 rounded-lg border border-gs-primary/20 bg-gs-soft p-3">
                                <h4 class="text-sm font-black text-gs-primary">{{ $command['step3']['review_title'] }}</h4>
                                <dl class="mt-2 grid gap-1.5 text-xs sm:grid-cols-2">
                                    @foreach (['agency', 'service', 'vehicle', 'date', 'period', 'contact'] as $field)
                                        <div class="flex justify-between gap-2 rounded-md bg-white px-2.5 py-1.5">
                                            <dt class="font-bold text-gs-grey">{{ $ticketFields[$field] }}</dt>
                                            <dd class="text-right font-black text-gs-ink" data-review-field="{{ $field }}">{{ $command['ticket']['empty'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>

                                <label class="mt-3 flex gap-2.5 text-xs font-bold leading-snug text-gs-ink">
                                    <input type="checkbox" name="confirmation_understood" class="mt-0.5 h-4 w-4 rounded border-gs-concrete text-gs-primary focus:ring-gs-primary" required>
                                    <span>{{ $command['step3']['confirm'] }}</span>
                                </label>
                            </div>

                            <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:justify-between">
                                <button type="button" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-primary px-4 text-xs font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" data-booking-prev>{{ $command['step2']['back'] }}</button>
                                <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                    {{ $command['step3']['submit'] }}
                                    <x-heroicon-o-paper-airplane class="h-4 w-4" aria-hidden="true" />
                                </button>
                            </div>
                        </section>
                    </form>

                    <div class="grid gap-2" data-booking-collapsed-steps>
                        <button type="button" class="flex min-h-12 items-center justify-between rounded-lg border border-gs-concrete bg-white px-4 text-left text-sm font-black uppercase text-gs-primary shadow-lg shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" data-booking-step-trigger="2">
                            <span class="inline-flex items-center gap-2.5">
                                <x-heroicon-o-truck class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                2. {{ $command['step2']['title'] }}
                            </span>
                            <x-heroicon-o-chevron-down class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                        </button>

                        <button type="button" class="flex min-h-12 items-center justify-between rounded-lg border border-gs-concrete bg-white px-4 text-left text-sm font-black uppercase text-gs-primary shadow-lg shadow-gs-navy/5 transition hover:border-gs-primary/50 hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2" data-booking-step-trigger="3">
                            <span class="inline-flex items-center gap-2.5">
                                <x-heroicon-o-user class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                                3. {{ $command['step3']['title'] }}
                            </span>
                            <x-heroicon-o-chevron-down class="h-5 w-5 text-gs-navy" aria-hidden="true" />
                        </button>
                    </div>

                    <div class="hidden rounded-lg border border-gs-concrete bg-white p-4 shadow-xl shadow-gs-navy/10 sm:p-5" data-booking-receipt>
                        <div class="flex flex-col gap-3 border-b border-gs-concrete pb-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="inline-flex rounded-md bg-gs-warning px-3 py-1 text-xs font-black uppercase text-gs-navy">{{ $command['receipt']['status'] }}</p>
                                <h3 class="mt-2 text-xl font-black uppercase text-gs-primary">{{ $command['receipt']['title'] }}</h3>
                            </div>
                            <p class="text-right text-xs font-bold text-gs-grey">
                                {{ $command['receipt']['reference'] }}<br>
                                <span class="text-lg font-black text-gs-navy" data-receipt-reference>GS-2026-NK-48192</span>
                            </p>
                        </div>

                        <dl class="mt-4 grid gap-2.5 sm:grid-cols-2">
                            @foreach (['agency', 'service', 'date', 'period'] as $field)
                                <div class="rounded-md border border-gs-concrete p-3">
                                    <dt class="text-[0.68rem] font-black uppercase text-gs-grey">{{ $ticketFields[$field] }}</dt>
                                    <dd class="mt-1 text-base font-black text-gs-ink" data-receipt-field="{{ $field }}">{{ $command['ticket']['empty'] }}</dd>
                                </div>
                            @endforeach
                            <div class="rounded-md border border-gs-warning bg-yellow-50 p-3 sm:col-span-2">
                                <dt class="text-[0.68rem] font-black uppercase text-gs-grey">{{ $command['receipt']['status_label'] }}</dt>
                                <dd class="mt-1 text-base font-black uppercase text-gs-navy">{{ $command['receipt']['status'] }}</dd>
                            </div>
                        </dl>

                        <p class="mt-4 rounded-md bg-gs-soft p-3 text-xs font-semibold leading-snug text-gs-ink">
                            {{ $command['receipt']['message'] }}
                        </p>

                        <div class="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                            <a href="{{ $trackingHref }}" class="inline-flex min-h-10 items-center justify-center rounded-md bg-gs-primary px-3 text-xs font-black text-white transition hover:bg-gs-navy">{{ $command['receipt']['track'] }}</a>
                            <a href="{{ $whatsappHref }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-success px-3 text-xs font-black text-gs-success transition hover:bg-green-50">{{ $command['receipt']['whatsapp'] }}</a>
                            <button type="button" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-primary px-3 text-xs font-black text-gs-primary transition hover:bg-gs-soft" data-booking-print>{{ $command['receipt']['print'] }}</button>
                            <a href="{{ $homeHref }}" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-concrete px-3 text-xs font-black text-gs-ink transition hover:bg-gs-wall">{{ $command['receipt']['home'] }}</a>
                        </div>
                    </div>

                    <div class="lg:hidden" data-booking-mobile-ticket-panel>
                        <div class="fixed inset-x-3 bottom-3 z-40">
                            <button type="button" class="flex min-h-11 w-full items-center justify-between rounded-md bg-gs-navy px-4 text-xs font-black text-white shadow-xl shadow-gs-navy/25" data-booking-mobile-ticket-toggle aria-expanded="false">
                                <span>{{ $command['mobile']['ticket_button'] }}</span>
                                <x-heroicon-o-chevron-down class="h-5 w-5 transition" aria-hidden="true" data-booking-mobile-ticket-chevron />
                            </button>

                            <div class="mt-2 hidden max-h-[55vh] overflow-y-auto rounded-lg border border-gs-concrete bg-white p-3 shadow-2xl shadow-gs-navy/25" data-booking-mobile-ticket>
                                <h3 class="flex items-center gap-2 text-sm font-black uppercase text-gs-primary">
                                    <x-heroicon-o-ticket class="h-5 w-5" aria-hidden="true" />
                                    {{ $command['ticket']['title'] }}
                                </h3>

                                <dl class="mt-3 grid gap-2 text-xs">
                                    @foreach ($ticketFields as $field => $label)
                                        <div class="flex justify-between gap-3 border-b border-gs-concrete/70 pb-2">
                                            <dt class="font-bold text-gs-grey">{{ $label }}</dt>
                                            <dd class="text-right font-black text-gs-primary">
                                                <span data-ticket-field="{{ $field }}">{{ $command['ticket']['empty'] }}</span>
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>

                                <div class="mt-3 rounded-md bg-gs-soft p-3">
                                    <p class="font-black text-gs-primary">{{ $command['documents']['title'] }}</p>
                                    <ul class="mt-2 space-y-1 text-xs font-semibold text-gs-ink">
                                        @foreach ($command['documents']['items'] as $item)
                                            <li class="flex gap-2">
                                                <x-heroicon-o-check-circle class="mt-0.5 h-3.5 w-3.5 shrink-0 text-gs-success" aria-hidden="true" />
                                                <span>{{ $item }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
