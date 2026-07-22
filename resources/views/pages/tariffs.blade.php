@extends('layouts.app')

@section('title', __('tariffs.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $hero = trans('tariffs.hero');
    $navigator = trans('tariffs.navigator');
    $matrix = trans('tariffs.matrix');
    $clarity = trans('tariffs.clarity');
    $tariffCategories = $navigator['categories'];
    $matrixRows = $matrix['rows'];
    $matrixCategories = collect($matrixRows)->pluck('category')->unique()->values();
    $bookingHref = route($routeLocale.'.booking', [], false);
    $conditionsHref = route($routeLocale.'.technical_inspection', [], false);
@endphp

@section('content')
    <section class="bg-gs-wall px-3 py-3 sm:px-6 sm:py-4 lg:px-32" aria-labelledby="tariffs-hero-title" data-tariffs-hero>
        <div class="mx-auto max-w-[122rem] overflow-hidden rounded-xl bg-gs-navy px-4 py-4 text-white shadow-xl shadow-gs-navy/20 sm:px-8 sm:py-5 lg:px-12 lg:py-5" style="background-image: linear-gradient(90deg, rgba(6, 42, 92, 0.98) 0%, rgba(6, 42, 92, 0.96) 45%, rgba(6, 42, 92, 0.94) 100%), url('{{ asset('images/servicespage/services-hero.png') }}'); background-position: center right; background-size: cover;">
            <div class="mx-auto max-w-[58rem] text-center xl:max-w-[76rem]">
                <p class="inline-flex min-h-7 items-center rounded-md bg-gs-accent px-3 text-xs font-black uppercase leading-none tracking-normal text-white shadow-md shadow-gs-navy/20 sm:min-h-8 sm:px-4 sm:text-sm lg:text-base">
                    {{ $hero['eyebrow'] }}
                </p>

                <h1 id="tariffs-hero-title" class="mx-auto mt-2 max-w-[54rem] text-[1.7rem] font-black leading-[1.05] text-white min-[390px]:text-[2rem] sm:text-4xl lg:text-[2.9rem]">
                    {{ $hero['title'] }}
                </h1>

                <p class="mx-auto mt-2 max-w-[46rem] text-sm font-semibold leading-snug text-white/90 sm:text-base lg:max-w-none lg:whitespace-nowrap lg:text-[clamp(0.82rem,1.12vw,1.25rem)]">
                    {{ $hero['lead'] }}
                </p>

                <div class="mx-auto mt-5 grid max-w-[52rem] grid-cols-2 gap-x-3 gap-y-2 sm:gap-3 lg:grid-cols-4 lg:gap-5">
                    @foreach ($hero['features'] as $feature)
                        <div class="flex min-w-0 items-center justify-center gap-2 text-white/95 sm:gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center text-white/90 sm:h-9 sm:w-9" aria-hidden="true">
                                @switch($feature['icon'])
                                    @case('clock')
                                        <x-heroicon-o-clock class="h-6 w-6 sm:h-7 sm:w-7" />
                                        @break
                                    @case('refresh')
                                        <x-heroicon-o-arrow-path class="h-6 w-6 sm:h-7 sm:w-7" />
                                        @break
                                    @case('print')
                                        <x-heroicon-o-printer class="h-6 w-6 sm:h-7 sm:w-7" />
                                        @break
                                    @default
                                        <x-heroicon-o-clipboard-document-list class="h-6 w-6 sm:h-7 sm:w-7" />
                                @endswitch
                            </span>

                            <span class="min-w-0 text-left text-[0.68rem] font-black leading-tight sm:text-xs lg:text-base">
                                {{ $feature['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-3 pb-6 pt-1 sm:px-6 sm:pb-8 lg:px-16 xl:px-32" aria-labelledby="tariff-navigator-title" data-tariff-navigator>
        <div class="mx-auto max-w-[122rem]">
            <div class="text-center">
                <h2 id="tariff-navigator-title" class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl lg:text-4xl">
                    {{ $navigator['title'] }}
                </h2>
                <div class="mx-auto mt-3 h-1 w-16 rounded-full bg-gs-accent" aria-hidden="true"></div>
                <p class="mt-4 text-sm font-semibold text-gs-ink-muted sm:text-base lg:text-lg">
                    {{ $navigator['lead'] }}
                </p>
                <p class="mx-auto mt-3 inline-flex min-h-9 items-center justify-center rounded-md border border-gs-primary/15 bg-white px-4 text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 sm:text-sm">
                    {{ $navigator['source_note'] }}
                </p>
            </div>

            <div class="mt-6 overflow-hidden rounded-xl border border-gs-primary/15 bg-white shadow-xl shadow-gs-navy/8">
                <div class="grid grid-cols-2 border-b border-gs-primary/15 sm:grid-cols-3 lg:grid-cols-6" role="tablist" aria-label="{{ $navigator['title'] }}">
                    @foreach ($tariffCategories as $category)
                        <button type="button" role="tab" id="tariff-tab-{{ $category['slug'] }}" aria-controls="tariff-panel-{{ $category['slug'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? '0' : '-1' }}" data-tariff-tab="{{ $category['slug'] }}" class="{{ $loop->first ? 'border-gs-primary bg-gs-primary text-white shadow-md shadow-gs-primary/20' : 'border-gs-primary/15 bg-white text-gs-navy hover:bg-gs-soft' }} flex min-h-20 items-center justify-center gap-2 border-b border-r px-2 text-left transition focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary sm:min-h-24 sm:gap-3 sm:px-3 lg:border-b-0">
                            <x-icons.tariff-vehicle :name="$category['icon']" class="h-8 w-8 shrink-0 sm:h-10 sm:w-10" />
                            <span class="min-w-0">
                                <span class="block text-[0.72rem] font-black leading-tight sm:text-sm lg:text-base">{{ $category['tab_label'] }}</span>
                                <span class="mt-1 block text-[0.65rem] font-black leading-tight opacity-80 sm:text-xs">{{ $category['tab_category'] }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>

                @foreach ($tariffCategories as $category)
                    <article id="tariff-panel-{{ $category['slug'] }}" role="tabpanel" aria-labelledby="tariff-tab-{{ $category['slug'] }}" data-tariff-panel="{{ $category['slug'] }}" class="{{ $loop->first ? '' : 'hidden' }}">
                        <div class="grid lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)_minmax(21rem,0.88fr)]">
                            <div class="flex items-center justify-center border-b border-gs-primary/10 bg-white px-4 py-3 sm:py-4 lg:border-b-0 lg:border-r lg:px-6 lg:py-5">
                                <img src="{{ asset($category['image']) }}" alt="{{ $category['image_alt'] }}" class="max-h-32 w-full max-w-[18rem] object-contain sm:max-h-48 sm:max-w-[26rem] lg:max-h-80 lg:max-w-[34rem]">
                            </div>

                            <div class="border-b border-gs-primary/10 px-5 py-5 lg:border-b-0 lg:border-r lg:px-7 lg:py-7">
                                <p class="text-lg font-black text-gs-primary sm:text-xl">
                                    {{ $category['category'] }}
                                </p>
                                <h3 class="mt-1 text-2xl font-black leading-tight text-gs-navy sm:text-3xl">
                                    {{ $category['title'] }}
                                </h3>
                                <p class="mt-4 text-sm font-semibold leading-relaxed text-gs-ink-muted sm:text-base">
                                    {{ $category['description'] }}
                                </p>

                                <dl class="mt-5 space-y-4 text-sm text-gs-ink sm:text-base">
                                    <div class="grid grid-cols-[2rem_1fr] gap-3">
                                        <x-heroicon-o-shield-check class="mt-0.5 h-6 w-6 text-gs-primary" aria-hidden="true" />
                                        <div>
                                            <dt class="font-black">{{ $navigator['service_label'] }} :</dt>
                                            <dd class="font-semibold">{{ $navigator['service_value'] }}</dd>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-[2rem_1fr] gap-3">
                                        <x-heroicon-o-map-pin class="mt-0.5 h-6 w-6 text-gs-primary" aria-hidden="true" />
                                        <div>
                                            <dt class="font-black">{{ $navigator['centres_label'] }} :</dt>
                                            <dd class="font-semibold">{{ $navigator['centres_value'] }}</dd>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-[2rem_1fr] gap-3">
                                        <x-heroicon-o-identification class="mt-0.5 h-6 w-6 text-gs-primary" aria-hidden="true" />
                                        <div>
                                            <dt class="font-black">{{ $navigator['examples_label'] }} :</dt>
                                            <dd class="font-semibold">{{ $category['examples'] }}</dd>
                                        </div>
                                    </div>
                                </dl>

                                <p class="mt-5 rounded-lg border border-gs-primary/15 bg-gs-soft px-4 py-3 text-sm font-bold leading-snug text-gs-navy">
                                    {{ $category['notice'] }}
                                </p>
                            </div>

                            <aside class="bg-gs-soft px-5 py-5 lg:px-7 lg:py-7">
                                <div class="rounded-xl bg-white p-5 shadow-lg shadow-gs-navy/8">
                                    <p class="text-sm font-black uppercase text-gs-primary sm:text-base">
                                        {{ isset($category['variants']) ? $navigator['prices_label'] : $navigator['price_label'] }}
                                    </p>

                                    @if (isset($category['variants']))
                                        <div class="mt-4 space-y-3">
                                            @foreach ($category['variants'] as $variant)
                                                <div class="grid grid-cols-[4rem_1fr] gap-3 rounded-lg border border-gs-primary/15 bg-gs-soft px-3 py-3">
                                                    <img src="{{ asset($variant['image']) }}" alt="{{ $variant['label'] }}" class="h-14 w-16 object-contain">
                                                    <div>
                                                        <p class="text-xs font-black uppercase text-gs-primary">{{ $variant['category'] }}</p>
                                                        <p class="mt-1 text-sm font-black text-gs-navy">{{ $variant['label'] }}</p>
                                                        <p class="mt-2 whitespace-nowrap text-2xl font-black leading-none text-gs-primary sm:text-3xl">
                                                            {{ $variant['price'] }}
                                                            <span class="text-sm font-black sm:text-base">{{ $category['price_suffix'] }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="mt-4 whitespace-nowrap text-[2.55rem] font-black leading-none text-gs-primary sm:text-5xl lg:text-[3.3rem]">
                                            {{ $category['price'] }}
                                            <span class="text-lg font-black sm:text-2xl">{{ $category['price_suffix'] }}</span>
                                        </p>
                                    @endif

                                    <dl class="mt-5 space-y-4 text-sm text-gs-ink sm:text-base">
                                        <div class="grid grid-cols-[1.75rem_1fr] gap-3">
                                            <x-heroicon-o-clock class="mt-0.5 h-5 w-5 text-gs-primary" aria-hidden="true" />
                                            <div>
                                                <dt class="inline font-black">{{ $navigator['validity_label'] }} :</dt>
                                                <dd class="inline font-semibold">{{ $category['validity'] }}</dd>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-[1.75rem_1fr] gap-3">
                                            <x-heroicon-o-calendar-days class="mt-0.5 h-5 w-5 text-gs-primary" aria-hidden="true" />
                                            <div>
                                                <dt class="inline font-black">{{ $navigator['effective_label'] }} :</dt>
                                                <dd class="inline font-semibold">{{ $category['effective_date'] }}</dd>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-[1.75rem_1fr] gap-3">
                                            <x-heroicon-o-receipt-percent class="mt-0.5 h-5 w-5 text-gs-primary" aria-hidden="true" />
                                            <p class="font-semibold leading-snug">{{ $navigator['tax_note'] }}</p>
                                        </div>
                                    </dl>

                                    <div class="mt-6 grid gap-3">
                                        <a href="{{ $bookingHref }}?categorie={{ urlencode($category['booking_category']) }}" class="hidden min-h-12 items-center justify-center gap-3 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:inline-flex sm:text-base">
                                            <x-heroicon-o-calendar-days class="h-6 w-6" aria-hidden="true" />
                                            <span>{{ $navigator['book_action'] }}</span>
                                            <x-heroicon-o-arrow-right class="ml-auto h-5 w-5" aria-hidden="true" />
                                        </a>

                                        <a href="{{ $conditionsHref }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md border border-gs-primary px-4 text-sm font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                                            <x-heroicon-o-document-text class="h-5 w-5" aria-hidden="true" />
                                            <span>{{ $navigator['conditions_action'] }}</span>
                                        </a>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-3 py-8 sm:px-6 sm:py-10 lg:px-16 xl:px-32" aria-labelledby="tariff-matrix-title" data-tariff-matrix>
        <div class="mx-auto max-w-[122rem]">
            <div class="text-center">
                <h2 id="tariff-matrix-title" class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl lg:text-4xl">
                    {{ $matrix['title'] }}
                </h2>
                <p class="mx-auto mt-3 max-w-[58rem] text-sm font-semibold leading-relaxed text-gs-ink-muted sm:text-base lg:text-lg">
                    {{ $matrix['lead'] }}
                </p>
            </div>

            <div class="mt-6 grid gap-3 lg:grid-cols-[minmax(18rem,1.25fr)_minmax(12rem,0.8fr)_minmax(13rem,0.9fr)_auto_auto_auto_auto]">
                <label class="relative block">
                    <span class="sr-only">{{ $matrix['search_placeholder'] }}</span>
                    <input type="search" placeholder="{{ $matrix['search_placeholder'] }}" data-tariff-matrix-search class="h-12 w-full rounded-md border border-gs-concrete bg-white pl-4 pr-11 text-sm font-semibold text-gs-ink shadow-sm shadow-gs-navy/5 transition placeholder:text-gs-ink-muted/70 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gs-primary" aria-hidden="true" />
                </label>

                <div class="grid grid-cols-2 gap-3 lg:contents">
                    <label class="block min-w-0">
                        <span class="sr-only">{{ $matrix['category_filter'] }}</span>
                        <select data-tariff-matrix-category class="h-11 w-full min-w-0 rounded-md border border-gs-concrete bg-white px-2 text-xs font-black text-gs-navy shadow-sm shadow-gs-navy/5 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20 sm:h-12 sm:px-4 sm:text-sm">
                            <option value="">{{ $matrix['category_filter'] }}</option>
                            @foreach ($matrixCategories as $category)
                                <option value="{{ $category }}">Cat. {{ $category }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block min-w-0">
                        <span class="sr-only">{{ $matrix['group_filter'] }}</span>
                        <select data-tariff-matrix-group class="h-11 w-full min-w-0 rounded-md border border-gs-concrete bg-white px-2 text-xs font-black text-gs-navy shadow-sm shadow-gs-navy/5 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20 sm:h-12 sm:px-4 sm:text-sm">
                            <option value="">{{ $matrix['group_filter'] }}</option>
                            @foreach ($matrix['groups'] as $group => $label)
                                <option value="{{ $group }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="grid grid-cols-4 gap-2 lg:contents">
                    <button type="button" data-tariff-matrix-print class="inline-flex min-h-11 min-w-0 flex-col items-center justify-center gap-0.5 rounded-md border border-gs-concrete bg-white px-1 text-center text-[0.58rem] font-black leading-tight text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-xs lg:min-h-12 lg:flex-row lg:gap-2 lg:px-4 lg:text-sm">
                        <span>{{ $matrix['actions']['print'] }}</span>
                        <x-heroicon-o-printer class="h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" />
                    </button>

                    <button type="button" data-tariff-matrix-download class="inline-flex min-h-11 min-w-0 flex-col items-center justify-center gap-0.5 rounded-md border border-gs-concrete bg-white px-1 text-center text-[0.58rem] font-black leading-tight text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-xs lg:min-h-12 lg:flex-row lg:gap-2 lg:px-4 lg:text-sm">
                        <x-heroicon-o-arrow-down-tray class="h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" />
                        <span>{{ $matrix['actions']['download'] }}</span>
                    </button>

                    <button type="button" data-tariff-matrix-share class="inline-flex min-h-11 min-w-0 flex-col items-center justify-center gap-0.5 rounded-md border border-gs-concrete bg-white px-1 text-center text-[0.58rem] font-black leading-tight text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-xs lg:min-h-12 lg:flex-row lg:gap-2 lg:px-4 lg:text-sm">
                        <span>{{ $matrix['actions']['share'] }}</span>
                        <x-heroicon-o-share class="h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" />
                    </button>

                    <button type="button" data-tariff-matrix-reset class="inline-flex min-h-11 min-w-0 flex-col items-center justify-center gap-0.5 rounded-md border border-gs-concrete bg-white px-1 text-center text-[0.58rem] font-black leading-tight text-gs-navy shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-xs lg:min-h-12 lg:flex-row lg:gap-2 lg:px-4 lg:text-sm">
                        <x-heroicon-o-arrow-path class="h-4 w-4 sm:h-5 sm:w-5" aria-hidden="true" />
                        <span>{{ $matrix['actions']['reset'] }}</span>
                    </button>
                </div>
            </div>

            <div class="mt-5 overflow-hidden rounded-lg border border-gs-concrete bg-white shadow-lg shadow-gs-navy/8">
                <table class="hidden w-full border-collapse md:table">
                    <thead class="bg-gs-primary text-white">
                        <tr>
                            <th scope="col" class="px-4 py-4 text-center text-sm font-black">{{ $matrix['headers']['category'] }}</th>
                            <th scope="col" class="px-4 py-4 text-left text-sm font-black">{{ $matrix['headers']['vehicle'] }}</th>
                            <th scope="col" class="px-4 py-4 text-center text-sm font-black">{{ $matrix['headers']['price'] }}</th>
                            <th scope="col" class="px-4 py-4 text-center text-sm font-black">{{ $matrix['headers']['validity'] }}</th>
                            <th scope="col" class="px-4 py-4 text-center text-sm font-black">{{ $matrix['headers']['info'] }}</th>
                            <th scope="col" class="px-4 py-4 text-center text-sm font-black">{{ $matrix['headers']['action'] }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gs-concrete">
                        @foreach ($matrixRows as $row)
                            <tr data-tariff-matrix-row data-category="{{ $row['category'] }}" data-group="{{ $row['group'] }}" data-search="{{ Str::lower($row['category'].' '.$row['vehicle'].' '.$row['price'].' '.$row['validity'].' '.$row['info'].' '.$row['keywords']) }}" class="transition hover:bg-gs-soft/50">
                                <td class="px-4 py-4 text-center text-2xl font-black text-gs-primary">{{ $row['category'] }}</td>
                                <td class="px-4 py-4 text-sm font-bold text-gs-ink lg:text-base">{{ $row['vehicle'] }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-center text-base font-black text-gs-navy lg:text-lg">{{ $row['price'] }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex min-h-8 items-center justify-center rounded-full bg-green-50 px-4 text-sm font-black text-gs-success">{{ $row['validity'] }}</span>
                                </td>
                                <td class="px-4 py-4 text-center text-sm font-semibold text-gs-ink-muted lg:text-base">{{ $row['info'] }}</td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ $bookingHref }}?categorie={{ urlencode($row['booking_category']) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md px-3 text-sm font-black text-gs-primary transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                        <span>{{ $matrix['actions']['book'] }}</span>
                                        <x-heroicon-o-arrow-right class="h-5 w-5" aria-hidden="true" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="grid gap-3 p-3 md:hidden">
                    @foreach ($matrixRows as $row)
                        <article data-tariff-matrix-card data-category="{{ $row['category'] }}" data-group="{{ $row['group'] }}" data-search="{{ Str::lower($row['category'].' '.$row['vehicle'].' '.$row['price'].' '.$row['validity'].' '.$row['info'].' '.$row['keywords']) }}" class="rounded-lg border border-gs-concrete bg-white p-4 shadow-sm shadow-gs-navy/5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-black uppercase text-gs-primary">{{ $matrix['headers']['category'] }}</p>
                                    <h3 class="mt-1 text-2xl font-black text-gs-navy">{{ $row['category'] }}</h3>
                                </div>
                                <p class="whitespace-nowrap text-xl font-black text-gs-navy">{{ $row['price'] }}</p>
                            </div>
                            <p class="mt-3 text-sm font-black text-gs-ink">{{ $row['vehicle'] }}</p>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="inline-flex min-h-8 items-center rounded-full bg-green-50 px-3 text-xs font-black text-gs-success">{{ $row['validity'] }}</span>
                                <span class="text-xs font-semibold text-gs-ink-muted">{{ $row['info'] }}</span>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="#tariff-panel-{{ $row['detail_slug'] }}" data-tariff-detail-link="{{ $row['detail_slug'] }}" class="inline-flex min-h-10 items-center justify-center rounded-md border border-gs-primary px-3 text-xs font-black text-gs-primary">
                                    {{ $matrix['actions']['details'] }}
                                </a>
                                <a href="{{ $bookingHref }}?categorie={{ urlencode($row['booking_category']) }}" class="inline-flex min-h-10 items-center justify-center rounded-md bg-gs-primary px-3 text-xs font-black text-white">
                                    {{ $matrix['actions']['book'] }}
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <p class="hidden px-4 py-6 text-center text-sm font-black text-gs-ink-muted" data-tariff-matrix-empty>
                    {{ $matrix['no_results'] }}
                </p>
            </div>

            <p class="mt-4 inline-flex items-center gap-3 rounded-md border border-gs-primary/15 bg-gs-soft px-4 py-3 text-sm font-bold text-gs-ink-muted">
                <x-heroicon-o-information-circle class="h-5 w-5 shrink-0 text-gs-primary" aria-hidden="true" />
                <span>{{ $matrix['notice'] }}</span>
            </p>
        </div>
    </section>

    <section class="bg-white px-3 pb-8 pt-2 sm:px-6 sm:pb-10 lg:px-16 xl:px-32" aria-labelledby="tariff-clarity-title" data-tariff-clarity>
        <div class="mx-auto max-w-[122rem]">
            <div>
                <h2 id="tariff-clarity-title" class="text-2xl font-black leading-tight text-gs-navy sm:text-3xl lg:text-4xl">
                    {{ $clarity['title'] }}
                </h2>
                <div class="mt-3 h-1 w-16 rounded-full bg-gs-accent" aria-hidden="true"></div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-4">
                @foreach ($clarity['items'] as $item)
                    <article class="grid min-h-40 grid-cols-1 gap-3 rounded-lg border border-gs-concrete bg-white p-3 shadow-sm shadow-gs-navy/5 sm:min-h-44 sm:p-4 lg:grid-cols-[3.5rem_1fr] lg:p-5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gs-soft text-gs-primary sm:h-14 sm:w-14 lg:h-14 lg:w-14" aria-hidden="true">
                            @switch($item['icon'])
                                @case('calendar')
                                    <x-heroicon-o-calendar-days class="h-7 w-7 sm:h-8 sm:w-8" />
                                    @break
                                @case('user')
                                    <x-heroicon-o-user-circle class="h-7 w-7 sm:h-8 sm:w-8" />
                                    @break
                                @case('shield')
                                    <x-heroicon-o-shield-check class="h-7 w-7 sm:h-8 sm:w-8" />
                                    @break
                                @default
                                    <x-icons.tariff-vehicle name="car" class="h-7 w-7 sm:h-8 sm:w-8" />
                            @endswitch
                        </div>

                        <div>
                            <h3 class="text-sm font-black leading-tight text-gs-navy sm:text-base lg:text-lg">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-2 text-xs font-semibold leading-relaxed text-gs-ink-muted sm:text-sm">
                                {{ $item['body'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
