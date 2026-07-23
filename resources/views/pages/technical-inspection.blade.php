@extends('layouts.app')

@section('title', __('inspection.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $hero = __('inspection.hero');
    $importance = __('inspection.importance');
    $controlPoints = __('inspection.control_points');
    $process = __('inspection.process');
    $preparation = __('inspection.preparation');
    $bookingHref = route($routeLocale.'.booking', [], false);
    $desktopTitleLines = $hero['desktop_title_lines'] ?? null;
@endphp

@section('content')
    <section class="relative isolate min-h-[470px] overflow-hidden bg-gs-navy text-white sm:min-h-[540px] lg:min-h-[500px]" aria-labelledby="inspection-hero-title" data-inspection-hero>
        <img
            src="{{ asset('images/inspection/hero-inspection.png') }}"
            alt=""
            class="absolute inset-0 -z-30 h-full w-full object-cover object-[68%_center] opacity-95 sm:object-[62%_center] lg:object-[58%_center]"
            aria-hidden="true"
        >

        <div class="absolute inset-0 -z-20 bg-gs-navy/24" aria-hidden="true"></div>
        <div
            class="absolute inset-0 -z-10"
            style="background: linear-gradient(90deg, rgba(6, 42, 92, 0.99) 0%, rgba(6, 42, 92, 0.94) 30%, rgba(6, 42, 92, 0.72) 49%, rgba(6, 42, 92, 0.34) 69%, rgba(6, 42, 92, 0.08) 100%);"
            aria-hidden="true"
        ></div>

        <div class="flex min-h-[470px] w-full items-center px-4 pb-14 pt-7 sm:min-h-[540px] sm:px-8 sm:pb-18 sm:pt-9 lg:min-h-[500px] lg:px-16 lg:pb-16 lg:pt-8 xl:px-24 2xl:px-[100px]">
            <div class="min-w-0 max-w-[72rem]">
                <p class="inline-flex min-h-8 items-center justify-center rounded-md bg-gs-accent px-4 text-[0.7rem] font-black uppercase leading-none tracking-normal text-white shadow-lg shadow-gs-navy/20 min-[380px]:text-xs sm:min-h-10 sm:px-6 sm:text-sm lg:text-base">
                    {{ $hero['eyebrow'] }}
                </p>

                <h1
                    id="inspection-hero-title"
                    @class([
                        'mt-4 text-[2rem] font-black leading-[1.04] tracking-normal text-white min-[380px]:text-[2.25rem] sm:mt-5 sm:text-[2.9rem]',
                        'max-w-[48rem] lg:text-[2.65rem] xl:text-[2.9rem]' => $desktopTitleLines,
                        'max-w-[42rem] lg:text-[3.35rem]' => ! $desktopTitleLines,
                    ])
                >
                    @if ($desktopTitleLines)
                        <span class="lg:hidden">{{ $hero['title'] }}</span>
                        <span class="hidden lg:block">
                            @foreach ($desktopTitleLines as $line)
                                <span class="block whitespace-nowrap">{{ $line }}</span>
                            @endforeach
                        </span>
                    @else
                        {{ $hero['title'] }}
                    @endif
                </h1>

                <p class="mt-4 max-w-[41rem] text-[0.82rem] font-bold leading-[1.42] tracking-normal text-white/90 min-[380px]:text-sm sm:mt-5 sm:text-lg sm:leading-[1.45] lg:text-[1.15rem]">
                    {{ $hero['lead'] }}
                </p>

                <div class="mt-5 hidden max-w-[41rem] gap-3 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-4 lg:mt-5 lg:gap-4" data-inspection-hero-actions>
                    <a href="{{ $hero['prepare_href'] }}" class="inline-flex min-h-13 items-center justify-center gap-2.5 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-xl shadow-gs-primary/30 transition hover:bg-gs-bay focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:px-5 sm:text-base lg:min-h-14">
                        <x-heroicon-o-document-text class="h-5 w-5 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ $hero['actions']['prepare'] }}</span>
                    </a>

                    <a href="{{ $bookingHref }}" class="inline-flex min-h-13 items-center justify-center gap-2.5 rounded-md border-2 border-white/70 bg-gs-navy/28 px-4 text-sm font-black text-white shadow-xl shadow-gs-navy/25 backdrop-blur-[2px] transition hover:border-white hover:bg-white/12 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy sm:px-5 sm:text-base lg:min-h-14">
                        <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0 sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ __('actions.book') }}</span>
                    </a>
                </div>

                <div class="mt-5 grid max-w-[66rem] grid-cols-2 gap-2 sm:mt-6 sm:gap-3 lg:mt-6 lg:grid-cols-4 lg:gap-3" data-inspection-hero-highlights>
                    @foreach ($hero['highlights'] as $item)
                        <div class="flex min-h-[4rem] min-w-0 items-center gap-2 rounded-lg border-2 border-white/30 bg-white/10 px-2.5 py-2 text-white shadow-xl shadow-gs-navy/20 backdrop-blur-[2px] sm:min-h-[4.4rem] sm:gap-3 sm:px-4 lg:min-h-[4rem]">
                            <x-dynamic-component :component="$item['icon']" class="h-5 w-5 shrink-0 text-white sm:h-6 sm:w-6" aria-hidden="true" />
                            <p class="min-w-0 text-[0.68rem] font-black leading-tight tracking-normal min-[380px]:text-xs sm:text-sm lg:text-[0.92rem]">
                                {{ $item['label'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="gs-inspection-caution-stripe pointer-events-none absolute inset-x-0 bottom-0" aria-hidden="true"></div>
    </section>

    <section class="bg-white px-4 py-6 sm:px-8 sm:py-8 lg:px-16 lg:pb-8 lg:pt-6 xl:px-24 2xl:px-[100px]" aria-labelledby="inspection-importance-title" data-inspection-importance>
        <div class="mx-auto grid max-w-[112rem] items-stretch gap-5 lg:grid-cols-[minmax(20rem,1.25fr)_repeat(3,minmax(0,0.95fr))] lg:gap-4 xl:grid-cols-[minmax(30rem,1.45fr)_repeat(3,minmax(0,0.85fr))] xl:gap-5">
            <div class="relative flex min-w-0 flex-col justify-center pl-5 sm:pl-7 lg:pr-8">
                <span class="absolute bottom-1 left-0 top-1 w-1.5 rounded-full bg-gs-accent" aria-hidden="true"></span>

                <h2 id="inspection-importance-title" class="max-w-[34rem] text-2xl font-black leading-tight tracking-normal text-gs-navy sm:text-3xl lg:text-[1.8rem] xl:text-[2rem]">
                    {{ $importance['title'] }}
                </h2>

                <p class="mt-3 max-w-[36rem] text-sm font-semibold leading-relaxed tracking-normal text-gs-ink-muted sm:text-base lg:text-[0.95rem] xl:text-base">
                    {{ $importance['lead'] }}
                </p>
            </div>

            @foreach ($importance['cards'] as $card)
                @php
                    $isDanger = ($card['tone'] ?? 'primary') === 'danger';
                    $iconClass = $isDanger ? 'text-gs-accent' : 'text-gs-primary';
                @endphp

                <article class="rounded-lg border border-gs-concrete/80 bg-white px-4 py-4 shadow-lg shadow-gs-navy/8 sm:px-6 sm:py-5 lg:px-5 xl:px-6">
                    <div class="grid grid-cols-[2.75rem_1fr] gap-3 sm:grid-cols-[4rem_1fr] sm:gap-5 lg:grid-cols-[3.45rem_1fr] lg:gap-4 xl:grid-cols-[3.75rem_1fr]">
                        <x-dynamic-component :component="$card['icon']" class="{{ $iconClass }} h-10 w-10 shrink-0 sm:h-14 sm:w-14 lg:h-11 lg:w-11 xl:h-12 xl:w-12" aria-hidden="true" />

                        <div class="min-w-0">
                            <h3 class="text-base font-black leading-tight tracking-normal text-gs-primary sm:text-xl lg:text-[1.05rem] xl:text-[1.2rem]">
                                {{ $card['title'] }}
                            </h3>

                            <p class="mt-2 text-[0.82rem] font-semibold leading-snug tracking-normal text-gs-ink sm:mt-3 sm:text-base sm:leading-relaxed lg:text-[0.9rem] xl:text-[0.95rem]">
                                {{ $card['copy'] }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-gs-wall px-4 py-6 sm:px-8 sm:py-8 lg:px-16 lg:pb-8 lg:pt-6 xl:px-24 2xl:px-[100px]" aria-labelledby="inspection-control-points-title" data-inspection-control-points>
        <div class="mx-auto max-w-[112rem]">
            <div class="text-center">
                <h2 id="inspection-control-points-title" class="text-2xl font-black leading-tight tracking-normal text-gs-navy sm:text-3xl lg:text-[2.35rem]">
                    {{ $controlPoints['title'] }}
                </h2>
                <p class="mx-auto mt-2 max-w-[58rem] text-sm font-black leading-snug tracking-normal text-gs-navy/85 sm:text-base lg:text-lg">
                    {{ $controlPoints['lead'] }}
                </p>
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4 lg:gap-4 xl:gap-5">
                @foreach ($controlPoints['items'] as $item)
                    <article class="grid min-h-[7.7rem] grid-cols-[4rem_1fr] items-center gap-4 rounded-lg border border-gs-concrete/80 bg-white px-4 py-4 shadow-md shadow-gs-navy/7 sm:min-h-[8.4rem] sm:grid-cols-[4.65rem_1fr] sm:px-5 lg:min-h-[8.1rem] lg:grid-cols-[4.8rem_1fr] lg:px-5 xl:grid-cols-[5.25rem_1fr] xl:px-6">
                        <img
                            src="{{ asset($item['icon']) }}"
                            alt=""
                            class="h-14 w-14 object-contain sm:h-16 sm:w-16 lg:h-[4.25rem] lg:w-[4.25rem] xl:h-[4.7rem] xl:w-[4.7rem]"
                            aria-hidden="true"
                        >

                        <div class="min-w-0">
                            <h3 class="text-base font-black leading-tight tracking-normal text-gs-navy sm:text-lg lg:text-[1.05rem] xl:text-[1.18rem]">
                                {{ $item['title'] }}
                            </h3>

                            <p class="mt-1.5 text-[0.82rem] font-semibold leading-snug tracking-normal text-gs-ink-muted sm:text-sm lg:text-[0.9rem] xl:text-base">
                                {{ $item['copy'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-6 sm:px-8 sm:py-8 lg:px-16 lg:pb-8 lg:pt-6 xl:px-24 2xl:px-[100px]" aria-labelledby="inspection-process-title" data-inspection-process>
        <div class="mx-auto max-w-[112rem]">
            <h2 id="inspection-process-title" class="text-center text-2xl font-black leading-tight tracking-normal text-gs-navy sm:text-3xl lg:text-[2.4rem]">
                {{ $process['title'] }}
            </h2>

            <div class="relative mt-6 lg:mt-7">
                <span class="absolute left-[9%] right-[9%] top-0 hidden h-1 rounded-full bg-gs-accent/70 lg:block" aria-hidden="true"></span>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:gap-5">
                    @foreach ($process['steps'] as $step)
                        <article class="relative grid min-h-[8.5rem] grid-cols-[3.5rem_1fr] items-center gap-4 rounded-lg border border-gs-concrete/80 bg-white px-4 py-4 shadow-md shadow-gs-navy/7 sm:min-h-[9.2rem] sm:grid-cols-[4rem_1fr] sm:px-5 lg:min-h-[10.8rem] lg:grid-cols-[4.4rem_1fr] lg:px-5 lg:pt-8 xl:min-h-[10.2rem]">
                            <span class="absolute -top-4 left-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-gs-accent text-lg font-black leading-none text-white shadow-lg shadow-gs-accent/25 sm:left-5 lg:-top-6 lg:left-1/2 lg:h-12 lg:w-12 lg:-translate-x-1/2 lg:text-xl">
                                {{ $loop->iteration }}
                            </span>

                            <img
                                src="{{ asset($step['icon']) }}"
                                alt=""
                                class="h-12 w-12 object-contain sm:h-14 sm:w-14 lg:h-15 lg:w-15"
                                aria-hidden="true"
                            >

                            <div class="min-w-0 pt-2 lg:pt-0">
                                <h3 class="text-base font-black leading-tight tracking-normal text-gs-navy sm:text-lg lg:text-[1.02rem] xl:text-[1.12rem]">
                                    {{ $step['title'] }}
                                </h3>

                                <p class="mt-2 text-[0.82rem] font-semibold leading-snug tracking-normal text-gs-ink-muted sm:text-sm lg:text-[0.88rem] xl:text-[0.95rem]">
                                    {{ $step['copy'] }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 grid gap-4 lg:grid-cols-3 lg:gap-5 xl:gap-6">
                @foreach ($process['outcomes'] as $outcome)
                    @php
                        $tone = $outcome['tone'];
                        $toneClasses = [
                            'success' => [
                                'panel' => 'border-gs-success/45 bg-green-50/25 shadow-gs-success/8',
                                'title' => 'text-gs-success',
                            ],
                            'warning' => [
                                'panel' => 'border-gs-warning/70 bg-yellow-50/25 shadow-gs-warning/10',
                                'title' => 'text-amber-500',
                            ],
                            'danger' => [
                                'panel' => 'border-gs-accent/45 bg-red-50/20 shadow-gs-accent/8',
                                'title' => 'text-gs-accent',
                            ],
                        ][$tone] ?? [
                            'panel' => 'border-gs-concrete bg-white shadow-gs-navy/7',
                            'title' => 'text-gs-primary',
                        ];
                    @endphp

                    <article class="{{ $toneClasses['panel'] }} grid min-h-[6.4rem] grid-cols-[4.25rem_1fr] items-center gap-4 rounded-lg border-2 px-4 py-4 shadow-md sm:grid-cols-[5rem_1fr] sm:px-5 lg:min-h-[7.2rem] lg:px-6">
                        <img
                            src="{{ asset($outcome['icon']) }}"
                            alt=""
                            class="h-14 w-14 object-contain sm:h-16 sm:w-16"
                            aria-hidden="true"
                        >

                        <div class="min-w-0">
                            <h3 class="{{ $toneClasses['title'] }} text-xl font-black leading-tight tracking-normal sm:text-2xl lg:text-[1.35rem] xl:text-[1.55rem]">
                                {{ $outcome['title'] }}
                            </h3>

                            <p class="mt-1 text-sm font-semibold leading-snug tracking-normal text-gs-ink sm:text-base lg:text-[0.95rem] xl:text-base">
                                {{ $outcome['copy'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gs-wall px-4 py-6 sm:px-8 sm:py-8 lg:px-16 lg:pb-8 lg:pt-6 xl:px-24 2xl:px-[100px]" aria-labelledby="inspection-preparation-title" data-inspection-preparation>
        <div class="mx-auto max-w-[112rem]">
            <h2 id="inspection-preparation-title" class="text-center text-2xl font-black leading-tight tracking-normal text-gs-navy sm:text-3xl lg:text-[2.35rem]">
                {{ $preparation['title'] }}
            </h2>

            <div class="mt-4 grid gap-4 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1.3fr)_minmax(18rem,0.82fr)] lg:gap-5 xl:grid-cols-[minmax(0,1.18fr)_minmax(0,1.34fr)_minmax(21rem,0.86fr)] xl:gap-6">
                @foreach ($preparation['cards'] as $card)
                    @if (($card['variant'] ?? 'light') === 'dark')
                        <article class="overflow-hidden rounded-lg border border-gs-primary/30 bg-gs-navy text-white shadow-lg shadow-gs-navy/18" data-inspection-preparation-scope>
                            <span class="block h-1.5 bg-gs-accent" aria-hidden="true"></span>

                            <div class="grid gap-5 px-5 py-5 sm:px-7 sm:py-6">
                                @foreach ($card['items'] as $item)
                                    <div @class([
                                        'grid grid-cols-[4.25rem_1fr] gap-5 sm:grid-cols-[5rem_1fr] sm:gap-6',
                                        'border-t border-white/24 pt-5' => ! $loop->first,
                                    ])>
                                        <div class="flex items-center border-l border-white/36 pl-4">
                                            <img
                                                src="{{ asset($item['icon']) }}"
                                                alt=""
                                                class="h-12 w-12 object-contain sm:h-14 sm:w-14"
                                                aria-hidden="true"
                                            >
                                        </div>

                                        <p class="text-sm font-bold leading-snug tracking-normal text-white/88 sm:text-base lg:text-[1.05rem]">
                                            {{ $item['copy'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @else
                        <article class="rounded-lg border border-gs-concrete/80 bg-white px-5 py-5 shadow-md shadow-gs-navy/7 sm:px-7 sm:py-6">
                            <div class="flex items-start gap-4">
                                <img
                                    src="{{ asset($card['icon']) }}"
                                    alt=""
                                    class="h-10 w-10 shrink-0 object-contain"
                                    aria-hidden="true"
                                >

                                <div class="min-w-0">
                                    <h3 class="text-xl font-black leading-tight tracking-normal text-gs-primary sm:text-2xl lg:text-[1.45rem]">
                                        {{ $card['title'] }}
                                    </h3>

                                    <ul class="mt-4 space-y-2.5">
                                        @foreach ($card['items'] as $item)
                                            <li class="grid grid-cols-[1.75rem_1fr] items-start gap-3">
                                                <img
                                                    src="{{ asset($item['icon']) }}"
                                                    alt=""
                                                    class="mt-0.5 h-5 w-5 object-contain"
                                                    aria-hidden="true"
                                                >
                                                <span class="text-sm font-semibold leading-snug tracking-normal text-gs-ink sm:text-base lg:text-[1.05rem]">
                                                    {{ $item['label'] }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-center gap-4 rounded-lg border-2 border-gs-primary/25 bg-gs-soft px-4 py-4 text-center text-gs-primary shadow-sm shadow-gs-primary/8 sm:px-6">
                <img
                    src="{{ asset($preparation['notice']['icon']) }}"
                    alt=""
                    class="h-8 w-8 shrink-0 object-contain"
                    aria-hidden="true"
                >
                <p class="text-sm font-black leading-snug tracking-normal sm:text-base lg:text-[1.1rem]">
                    {{ $preparation['notice']['copy'] }}
                </p>
            </div>
        </div>
    </section>
@endsection
