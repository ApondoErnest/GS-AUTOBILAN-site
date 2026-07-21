@extends('layouts.app')

@section('title', __('tracking.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $lookup = trans('tracking.lookup');
    $result = trans('tracking.result');
    $whatsappHref = 'https://wa.me/237678844791?text='.rawurlencode($result['next_action']['title']);
    $callHref = 'tel:+237678844791';
@endphp

@section('content')
    <section class="bg-gs-wall px-3 py-3 sm:px-6 sm:py-4 lg:px-32" aria-labelledby="tracking-hero-title" data-tracking-hero>
        <div class="mx-auto max-w-[122rem] overflow-hidden rounded-xl bg-gs-navy px-4 py-4 text-white shadow-xl shadow-gs-navy/20 sm:px-8 sm:py-5 lg:px-12 lg:py-5" style="background: radial-gradient(circle at 82% 24%, rgba(20, 93, 179, 0.72) 0%, rgba(11, 58, 117, 0.84) 31%, rgba(6, 42, 92, 0.98) 66%), linear-gradient(135deg, #062a5c 0%, #0b3a75 54%, #145db3 100%);">
            <div class="max-w-[112rem]">
                <p class="inline-flex min-h-7 items-center rounded-md bg-gs-accent px-3 text-[0.65rem] font-black uppercase leading-none text-white shadow-md shadow-gs-navy/20 sm:min-h-8 sm:px-4 sm:text-sm lg:text-base">
                    {{ __('tracking.hero.eyebrow') }}
                </p>

                <h1 id="tracking-hero-title" class="mt-2 whitespace-nowrap text-[0.75rem] font-black leading-tight text-white min-[390px]:text-sm sm:text-3xl lg:text-[2.5rem]">
                    {!! __('tracking.hero.title') !!}
                </h1>

                <p class="mt-1 max-w-[44rem] text-[0.64rem] font-medium leading-snug text-white/95 min-[390px]:text-[0.7rem] sm:text-base lg:max-w-[64rem] lg:text-lg">
                    {!! __('tracking.hero.lead') !!}
                </p>

                <div class="mt-3 flex items-center gap-3 rounded-md border border-white/70 bg-white/95 px-3 py-2 text-gs-ink shadow-lg shadow-gs-navy/15 sm:gap-4 sm:px-5 sm:py-3 lg:mt-3 lg:px-4 lg:py-2" data-tracking-hero-notice>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gs-primary text-white shadow-sm sm:h-11 sm:w-11 lg:h-10 lg:w-10" aria-hidden="true">
                        <x-heroicon-o-information-circle class="h-6 w-6 sm:h-7 sm:w-7 lg:h-6 lg:w-6" />
                    </span>

                    <p class="text-[0.62rem] font-medium leading-snug min-[390px]:text-xs sm:text-sm lg:text-sm">
                        <strong class="font-black">{{ __('tracking.hero.notice.label') }} :</strong>
                        {{ __('tracking.hero.notice.body') }}
                        {{ __('tracking.hero.notice.confirmation') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-3 pb-10 pt-3 sm:px-6 lg:px-64" aria-labelledby="tracking-lookup-title" data-tracking-lookup>
        <div class="mx-auto max-w-[122rem]">
            <form action="{{ route($routeLocale.'.tracking', [], false) }}" method="get" class="relative overflow-hidden rounded-xl border border-gs-concrete bg-white px-4 py-5 shadow-xl shadow-gs-navy/8 sm:px-6 sm:py-6 lg:px-7 lg:py-7" data-tracking-lookup-form>
                <span class="absolute left-0 top-7 hidden h-16 w-1 rounded-r-full bg-gs-accent lg:block" aria-hidden="true"></span>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex min-w-0 items-start gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gs-soft text-gs-primary shadow-sm shadow-gs-navy/10" aria-hidden="true">
                            <x-heroicon-o-clipboard-document-list class="h-6 w-6" />
                        </span>

                        <div class="min-w-0">
                            <h2 id="tracking-lookup-title" class="text-xl font-black leading-tight text-gs-navy sm:text-2xl">
                                {{ $lookup['title'] }}
                            </h2>
                            <p class="mt-1 text-sm font-semibold leading-snug text-gs-ink-muted sm:text-base">
                                {{ $lookup['lead'] }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route($routeLocale.'.contact', [], false) }}" class="inline-flex items-center gap-2 self-start rounded-md px-1 text-sm font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary/25">
                        <x-heroicon-o-question-mark-circle class="h-5 w-5" aria-hidden="true" />
                        {{ $lookup['help'] }}
                    </a>
                </div>

                <div class="mt-6 grid gap-4 lg:grid-cols-3">
                    <label class="block">
                        <span class="text-sm font-black text-gs-ink">{{ $lookup['fields']['reference']['label'] }}</span>
                        <span class="relative mt-2 block">
                            <input type="text" name="reference" autocomplete="off" class="h-12 w-full rounded-md border-2 border-gs-concrete bg-white px-4 pr-12 text-base font-bold text-gs-ink placeholder:text-gs-grey/70 shadow-sm shadow-gs-navy/5 transition focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" placeholder="{{ $lookup['fields']['reference']['placeholder'] }}">
                            <x-heroicon-o-ticket class="pointer-events-none absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 text-gs-primary" aria-hidden="true" />
                        </span>
                    </label>

                    <label class="block">
                        <span class="text-sm font-black text-gs-ink">{{ $lookup['fields']['phone']['label'] }}</span>
                        <span class="relative mt-2 block">
                            <input type="tel" name="phone" autocomplete="tel" class="h-12 w-full rounded-md border-2 border-gs-concrete bg-white px-4 pr-12 text-base font-bold text-gs-ink placeholder:text-gs-grey/70 shadow-sm shadow-gs-navy/5 transition focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" placeholder="{{ $lookup['fields']['phone']['placeholder'] }}">
                            <x-heroicon-o-phone class="pointer-events-none absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 text-gs-primary" aria-hidden="true" />
                        </span>
                    </label>

                    <label class="block">
                        <span class="text-sm font-black text-gs-ink">{{ $lookup['fields']['registration']['label'] }}</span>
                        <span class="relative mt-2 block">
                            <input type="text" name="vehicle_registration" autocomplete="off" class="h-12 w-full rounded-md border-2 border-gs-concrete bg-white px-4 pr-20 text-base font-bold uppercase text-gs-ink placeholder:normal-case placeholder:text-gs-grey/70 shadow-sm shadow-gs-navy/5 transition focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20" placeholder="{{ $lookup['fields']['registration']['placeholder'] }}">
                            <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 rounded border-2 border-gs-primary/70 px-1.5 py-0.5 text-[0.64rem] font-black leading-none text-gs-primary" aria-hidden="true">ABC-123</span>
                        </span>
                    </label>
                </div>

                <div class="mt-6 flex justify-center">
                    <button type="submit" class="inline-flex min-h-12 w-full max-w-[29rem] items-center justify-center gap-3 rounded-md bg-gs-primary px-5 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:text-base">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5" aria-hidden="true" />
                        {{ $lookup['submit'] }}
                    </button>
                </div>

                <div class="mt-6 border-t border-gs-concrete pt-5 text-center">
                    <p class="flex flex-col items-center justify-center gap-2 text-sm font-bold text-gs-ink sm:flex-row sm:text-base">
                        <span>{{ $lookup['recovery_prompt'] }}</span>
                        <a href="{{ route($routeLocale.'.contact', [], false) }}" class="inline-flex items-center gap-2 font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary/25">
                            {{ $lookup['recovery_action'] }}
                            <x-heroicon-o-arrow-right class="h-5 w-5" aria-hidden="true" />
                        </a>
                    </p>
                </div>
            </form>

            <article class="mt-4 overflow-hidden rounded-xl border border-gs-concrete bg-white px-3 py-4 shadow-xl shadow-gs-navy/8 sm:px-6 sm:py-6 lg:px-7 lg:py-7" data-tracking-result>
                <div class="-mx-1 overflow-x-auto pb-2 sm:mx-0 sm:overflow-visible sm:pb-0">
                    <ol class="grid min-w-[38rem] grid-cols-4 gap-2 rounded-xl bg-gs-soft/70 p-2.5 sm:min-w-0 sm:gap-4 sm:bg-transparent sm:p-0" aria-label="{{ $result['status']['title'] }}">
                        @foreach ($result['timeline'] as $step)
                            @php
                                $isCompleted = $step['state'] === 'completed';
                                $isCurrent = $step['state'] === 'current';
                                $nodeClasses = $isCompleted || $isCurrent
                                    ? 'bg-gs-primary text-white shadow-md shadow-gs-primary/25'
                                    : 'bg-gs-grey text-white shadow-sm shadow-gs-navy/10';
                                $connectorClasses = $isCompleted ? 'bg-gs-primary' : 'bg-gs-concrete';
                            @endphp

                            <li class="relative rounded-lg bg-white p-2.5 text-center shadow-sm shadow-gs-navy/5 sm:bg-transparent sm:p-0 sm:shadow-none">
                                @unless ($loop->last)
                                    <span class="absolute left-[calc(50%+1.35rem)] right-[calc(-50%+1.35rem)] top-[1.65rem] h-1 rounded-full {{ $connectorClasses }} sm:top-5" aria-hidden="true"></span>
                                @endunless

                                <span class="relative z-10 mx-auto flex h-9 w-9 items-center justify-center rounded-full text-sm font-black sm:h-10 sm:w-10 {{ $nodeClasses }}">
                                    @if ($isCompleted)
                                        <x-heroicon-o-check class="h-5 w-5" aria-hidden="true" />
                                    @else
                                        {{ $loop->iteration }}
                                    @endif
                                </span>

                                <span class="mt-2 block text-xs font-black leading-tight text-gs-ink sm:mt-3 sm:text-sm">{{ $step['label'] }}</span>
                                <span class="mt-1 block text-xs font-semibold leading-tight text-gs-ink-muted sm:text-sm">{{ $step['meta'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <section class="relative mt-4 overflow-hidden rounded-xl border border-gs-concrete bg-gradient-to-br from-white via-white to-gs-success/5 p-3.5 shadow-sm shadow-gs-navy/5 sm:mt-6 sm:p-5 lg:p-6" aria-labelledby="tracking-status-title">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-gs-success" aria-hidden="true"></span>

                    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex min-w-0 flex-col gap-3 sm:flex-row sm:items-start sm:gap-4">
                            <p class="inline-flex min-h-10 items-center gap-2 self-start rounded-full bg-gs-success px-4 text-xs font-black uppercase text-white shadow-lg shadow-gs-success/25 sm:min-h-12 sm:px-5 sm:text-base">
                                <x-heroicon-o-check-circle class="h-6 w-6" aria-hidden="true" />
                                {{ $result['status']['label'] }}
                            </p>

                            <div class="min-w-0">
                                <h2 id="tracking-status-title" class="text-lg font-black leading-tight text-gs-ink sm:text-2xl">
                                    {{ $result['status']['title'] }}
                                </h2>
                                <p class="mt-1 text-sm font-semibold leading-snug text-gs-ink-muted sm:text-base">
                                    {{ $result['status']['body'] }}
                                </p>
                            </div>
                        </div>

                        <button type="button" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-primary/35 bg-white px-3 text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary/25 sm:min-h-11 sm:px-4 sm:text-sm">
                            <x-heroicon-o-arrow-down-tray class="h-5 w-5" aria-hidden="true" />
                            {{ $result['status']['download'] }}
                        </button>
                    </div>

                    <dl class="mt-5 grid grid-cols-2 gap-2.5 sm:mt-6 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-y-6">
                        @foreach ($result['details'] as $item)
                            <div class="grid min-w-0 grid-cols-[1.55rem_minmax(0,1fr)] gap-2 rounded-lg border border-gs-concrete/80 bg-white/85 p-2.5 shadow-sm shadow-gs-navy/5 sm:grid-cols-[2rem_1fr] sm:gap-3 sm:border-0 sm:bg-transparent sm:p-0 sm:shadow-none lg:pl-6 {{ $loop->iteration % 3 === 1 ? 'lg:pl-0' : 'lg:border-l lg:border-gs-concrete' }}">
                                @switch($item['icon'])
                                    @case('ticket')
                                        <x-heroicon-o-ticket class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('map')
                                        <x-heroicon-o-map-pin class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('calendar')
                                        <x-heroicon-o-calendar-days class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('service')
                                        <x-heroicon-o-clipboard-document-list class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('vehicle')
                                        <x-heroicon-o-truck class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('clock')
                                        <x-heroicon-o-clock class="mt-1 h-5 w-5 text-gs-primary sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                    @case('plate')
                                        <span class="mt-1 inline-flex h-5 w-7 items-center justify-center rounded border border-gs-primary/60 text-[0.44rem] font-black leading-none text-gs-primary sm:h-6 sm:w-8 sm:text-[0.48rem]" aria-hidden="true">REG</span>
                                        @break
                                    @case('whatsapp')
                                        <x-heroicon-o-phone class="mt-1 h-5 w-5 text-gs-success sm:h-6 sm:w-6" aria-hidden="true" />
                                        @break
                                @endswitch

                                <div>
                                    <dt class="text-xs font-black leading-tight text-gs-grey sm:text-sm">{{ $item['label'] }}</dt>
                                    <dd class="mt-1 break-words text-sm font-black leading-snug text-gs-ink sm:text-base">{{ $item['value'] }}</dd>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <div class="mt-3 grid gap-3 sm:mt-4 sm:gap-4 lg:grid-cols-[0.95fr_1.05fr]">
                    <section class="rounded-xl border border-gs-success/20 bg-gs-success/5 p-3.5 sm:p-5" aria-labelledby="tracking-dossier-title">
                        <div class="flex gap-3 sm:gap-4">
                            <span class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gs-success/10 text-gs-success sm:h-12 sm:w-12" aria-hidden="true">
                                <x-heroicon-o-check-circle class="h-6 w-6 sm:h-7 sm:w-7" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase text-gs-success sm:text-sm">{{ $result['dossier']['eyebrow'] }}</p>
                                <h3 id="tracking-dossier-title" class="mt-1.5 text-lg font-black leading-tight text-gs-ink sm:mt-2 sm:text-2xl">
                                    {{ $result['dossier']['title'] }}
                                </h3>
                                <p class="mt-2 text-sm font-semibold leading-snug text-gs-ink-muted sm:text-base">
                                    {{ $result['dossier']['body'] }}
                                </p>

                                <button type="button" class="mt-3 inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-md border border-gs-primary/35 bg-white px-3 text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary/25 sm:mt-4 sm:min-h-11 sm:w-auto sm:px-4 sm:text-sm">
                                    {{ $result['dossier']['action'] }}
                                    <x-heroicon-o-arrow-right class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-gs-primary/20 bg-gs-soft p-3.5 sm:p-5" aria-labelledby="tracking-next-action-title">
                        <div class="flex gap-3 sm:gap-4">
                            <span class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gs-primary/10 text-gs-primary sm:h-12 sm:w-12" aria-hidden="true">
                                <x-heroicon-o-information-circle class="h-6 w-6 sm:h-7 sm:w-7" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase text-gs-primary sm:text-sm">{{ $result['next_action']['eyebrow'] }}</p>
                                <h3 id="tracking-next-action-title" class="mt-1.5 text-lg font-black leading-tight text-gs-ink sm:mt-2 sm:text-2xl">
                                    {{ $result['next_action']['title'] }}
                                </h3>
                                <p class="mt-2 text-sm font-semibold leading-snug text-gs-ink-muted sm:text-base">
                                    {{ $result['next_action']['body'] }}
                                </p>

                                <div class="mt-3 grid grid-cols-2 gap-2.5 sm:mt-4 sm:gap-3">
                                    <a href="{{ $whatsappHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md bg-gs-success px-3 text-xs font-black text-white shadow-lg shadow-gs-success/20 transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-gs-success focus:ring-offset-2 sm:min-h-11 sm:px-4 sm:text-sm">
                                        <x-heroicon-o-phone class="h-5 w-5" aria-hidden="true" />
                                        {{ $result['next_action']['whatsapp'] }}
                                    </a>

                                    <a href="{{ $callHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-primary/35 bg-white px-3 text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary/25 sm:min-h-11 sm:px-4 sm:text-sm">
                                        <x-heroicon-o-phone class="h-5 w-5" aria-hidden="true" />
                                        {{ $result['next_action']['call'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </section>
@endsection
