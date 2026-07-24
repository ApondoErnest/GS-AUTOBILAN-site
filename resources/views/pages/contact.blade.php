@extends('layouts.app')

@section('title', __('contact.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $intro = __('contact.intro');
    $agencies = __('contact.agencies');
    $desk = __('contact.desk');
    $faq = __('contact.faq');
    $bookingHref = route($routeLocale.'.booking', [], false);
    $selectedAgency = old('agency_slug', request()->query('agence'));
    $agencyValues = array_column($desk['form']['agency_options'], 'value');
    $selectedAgency = in_array($selectedAgency, $agencyValues, true) ? $selectedAgency : null;
    $controlClass = 'h-9 w-full rounded-md border border-gs-concrete bg-white px-2.5 text-xs font-semibold text-gs-ink shadow-sm shadow-gs-navy/5 transition placeholder:text-gs-grey/70 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20 sm:h-10 sm:px-3 sm:text-sm lg:h-11';
    $inputClass = 'mt-1.5 '.$controlClass;
    $selectClass = $controlClass.' appearance-none pr-10';
    $textAreaClass = 'mt-1.5 min-h-16 w-full rounded-md border border-gs-concrete bg-white px-2.5 py-2 text-xs font-semibold leading-snug text-gs-ink shadow-sm shadow-gs-navy/5 transition placeholder:text-gs-grey/70 focus:border-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary/20 sm:min-h-20 sm:px-3 sm:py-2.5 sm:text-sm';
    $actionHrefMap = [
        'booking' => $bookingHref,
        'call' => '#contact-agencies',
        'directions' => route($routeLocale.'.agencies', [], false),
        'question' => '#contact-form',
    ];
@endphp

@section('content')
    <section class="bg-white px-3 py-5 sm:px-8 sm:py-8 lg:px-16 lg:py-10 xl:px-24 2xl:px-[100px]" aria-labelledby="contact-intro-title" data-contact-intro>
        <div class="mx-auto max-w-[104rem]">
            <div class="text-center">
                <div class="mx-auto h-0.5 w-10 rounded-full bg-gs-accent sm:h-1 sm:w-14" aria-hidden="true"></div>

                <h1 id="contact-intro-title" class="mt-2 text-xl font-black leading-tight tracking-normal text-gs-navy sm:mt-3 sm:text-3xl lg:text-[2.25rem]">
                    {{ $intro['title'] }}
                </h1>

                <p class="mt-1.5 text-xs font-semibold leading-snug tracking-normal text-gs-ink-muted sm:mt-2 sm:text-base lg:text-lg">
                    {{ $intro['lead'] }}
                </p>
            </div>

            <div class="mx-auto mt-4 grid max-w-[92rem] grid-cols-2 gap-2 sm:mt-6 sm:gap-4 lg:grid-cols-4 lg:gap-6">
                @foreach ($intro['actions'] as $action)
                    <a href="{{ $actionHrefMap[$action['target']] }}" class="group relative grid min-h-[5.25rem] grid-cols-[2rem_1fr] items-center gap-2 overflow-hidden rounded-lg border border-gs-concrete/80 bg-white px-2.5 py-2.5 text-left shadow-md shadow-gs-navy/7 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-gs-navy/12 focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 min-[380px]:grid-cols-[2.2rem_1fr] sm:min-h-[11.5rem] sm:flex sm:flex-col sm:justify-center sm:px-5 sm:py-6 sm:text-center lg:min-h-[12.2rem]">
                        <span class="absolute inset-x-0 bottom-0 h-1 bg-gs-accent sm:h-1.5" aria-hidden="true"></span>

                        <img
                            src="{{ asset($action['icon']) }}"
                            alt=""
                            class="h-7 w-7 object-contain min-[380px]:h-8 min-[380px]:w-8 sm:h-16 sm:w-16"
                            aria-hidden="true"
                        >

                        <span class="min-w-0 text-[0.72rem] font-black leading-tight tracking-normal text-gs-navy min-[380px]:text-[0.78rem] sm:mt-5 sm:max-w-[12rem] sm:text-xl">
                            {!! $action['label'] !!}
                        </span>

                        <x-heroicon-o-chevron-right class="absolute bottom-2.5 right-2.5 h-3.5 w-3.5 text-gs-ink-muted transition group-hover:translate-x-0.5 group-hover:text-gs-primary sm:bottom-6 sm:right-5 sm:h-5 sm:w-5" aria-hidden="true" />
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact-agencies" class="bg-white px-3 py-4 sm:px-8 sm:py-7 lg:px-16 lg:py-8 xl:px-64" aria-labelledby="contact-agencies-title" data-contact-agencies>
        <div class="mx-auto max-w-none">
            <div class="text-center">
                <div class="mx-auto h-0.5 w-10 rounded-full bg-gs-accent sm:h-1 sm:w-14" aria-hidden="true"></div>

                <h2 id="contact-agencies-title" class="mt-2 text-xl font-black leading-tight tracking-normal text-gs-navy sm:mt-3 sm:text-3xl lg:text-[2rem]">
                    {{ $agencies['title'] }}
                </h2>
            </div>

            <div class="mt-3 space-y-3 sm:mt-5 sm:space-y-4">
                @foreach ($agencies['cards'] as $agency)
                    <article id="{{ $agency['id'] }}" class="relative overflow-hidden rounded-lg border border-gs-concrete/80 bg-white shadow-md shadow-gs-navy/8" data-contact-agency-card>
                        <span class="absolute inset-y-0 left-0 w-1 bg-gs-accent sm:w-1.5" aria-hidden="true"></span>

                        <div class="grid lg:min-h-[17rem] lg:grid-cols-[minmax(0,1fr)_minmax(18rem,0.95fr)]">
                            <div class="min-w-0 px-4 py-4 pl-6 sm:px-7 sm:py-6 sm:pl-9 lg:px-7 lg:py-6 lg:pl-9">
                                <div class="grid gap-2 sm:grid-cols-[1fr_auto] sm:items-start sm:gap-3">
                                    <h3 class="text-lg font-black leading-tight tracking-normal text-gs-navy sm:text-2xl lg:text-[1.55rem]">
                                        {{ $agency['name'] }}
                                    </h3>

                                    <span class="inline-flex w-fit items-center rounded-md bg-green-50 px-2.5 py-1 text-[0.68rem] font-black leading-none text-gs-success sm:px-3 sm:py-1.5 sm:text-sm">
                                        {{ $agencies['status'] }}
                                    </span>
                                </div>

                                <div class="mt-3 grid gap-3 sm:mt-4 sm:gap-4 lg:grid-cols-[minmax(0,1fr)_auto]">
                                    <div class="space-y-2.5 text-xs font-semibold leading-snug text-gs-ink-muted sm:space-y-3 sm:text-base">
                                        <p class="flex gap-2.5 sm:gap-3">
                                            <x-heroicon-s-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                                            <span>{{ $agency['address'] }}</span>
                                        </p>

                                        <p class="flex gap-2.5 sm:gap-3">
                                            <x-heroicon-o-clock class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                                            <span>{!! $agency['hours'] !!}</span>
                                        </p>

                                        <p class="flex gap-2.5 sm:gap-3">
                                            <x-heroicon-s-phone class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                                            <span>{{ $agency['phone'] }}</span>
                                        </p>

                                        <p class="flex gap-2.5 sm:gap-3">
                                            <x-heroicon-o-envelope class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                                            <span>{{ $agency['email'] }}</span>
                                        </p>
                                    </div>

                                    <p class="flex gap-2.5 text-xs font-semibold leading-snug text-gs-ink-muted sm:gap-3 sm:text-base lg:min-w-[11rem]">
                                        <x-heroicon-o-calendar-days class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                                        <span>{{ $agency['note'] }}</span>
                                    </p>
                                </div>

                                <div class="mt-3 grid grid-cols-2 gap-2 sm:mt-4 sm:max-w-[25rem] sm:gap-2.5">
                                    <a href="{{ $agency['whatsappHref'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-md border-2 border-gs-success/45 bg-white px-2 text-xs font-black text-gs-success shadow-sm shadow-gs-navy/5 transition hover:border-gs-success hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-gs-success focus:ring-offset-2 sm:min-h-11 sm:gap-2 sm:px-3 sm:text-sm">
                                        <svg class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M7.3 19.6 3 21l1.4-4.1A8.3 8.3 0 1 1 7.3 19.6Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            <path d="M8.8 8.9c.2-.5.4-.5.7-.5h.6c.2 0 .4 0 .6.5l.7 1.6c.1.3.1.5-.1.7l-.4.5c-.2.2-.2.4-.1.6.4.8 1.2 1.6 2.1 2 .2.1.4.1.6-.1l.6-.7c.2-.2.4-.2.7-.1l1.6.7c.4.2.5.4.5.6 0 .7-.5 1.5-1.1 1.8-.8.4-2.6.1-4.5-1.1-1.7-1.1-3-2.8-3.5-4.2-.5-1.2 0-2 .3-2.3Z" fill="currentColor" />
                                        </svg>
                                        <span>{{ __('actions.whatsapp') }}</span>
                                    </a>

                                    <a href="{{ $bookingHref }}" class="inline-flex min-h-9 items-center justify-center gap-1.5 rounded-md bg-gs-primary px-2 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:min-h-11 sm:gap-2 sm:px-3 sm:text-sm">
                                        <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                                        <span>{{ $agencies['actions']['book'] }}</span>
                                    </a>
                                </div>
                            </div>

                            <div class="min-h-[10rem] overflow-hidden border-t border-gs-concrete bg-gs-soft sm:min-h-[13rem] lg:min-h-full lg:border-l lg:border-t-0">
                                <iframe
                                    src="{{ $agency['mapEmbed'] }}"
                                    title="{{ $agency['mapTitle'] }}"
                                    class="h-full min-h-[10rem] w-full sm:min-h-[14rem] lg:min-h-full"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact-form" class="bg-gs-wall px-3 py-3 sm:px-8 sm:py-7 lg:px-16 lg:py-8 xl:px-64" aria-label="{{ $desk['form']['title'] }}" data-contact-desk>
        <div class="mx-auto grid max-w-none gap-3 sm:gap-4 lg:grid-cols-[1.35fr_0.95fr] lg:gap-5">
            <aside class="order-1 rounded-lg border border-gs-concrete bg-white p-4 shadow-md shadow-gs-navy/8 sm:p-5 lg:order-2 lg:p-6" data-contact-head-office>
                <p class="inline-flex rounded-md bg-gs-concrete/60 px-2.5 py-1 text-[0.68rem] font-black uppercase tracking-normal text-gs-grey sm:px-3 sm:text-xs">
                    {{ $desk['head_office']['label'] }}
                </p>

                <h2 class="mt-1.5 text-lg font-black leading-tight tracking-normal text-gs-navy sm:mt-2 sm:text-2xl lg:text-[1.45rem]">
                    {{ $desk['head_office']['title'] }}
                </h2>

                <div class="mt-2 h-0.5 w-7 rounded-full bg-gs-navy sm:mt-3 sm:h-1 sm:w-8" aria-hidden="true"></div>

                <p class="mt-2 max-w-md text-xs font-semibold leading-snug text-gs-ink-muted sm:mt-3 sm:text-base sm:leading-relaxed">
                    {{ $desk['head_office']['lead'] }}
                </p>

                <div class="mt-4 space-y-2.5 text-xs font-semibold leading-snug text-gs-ink-muted sm:mt-6 sm:space-y-4 sm:text-base">
                    <p class="flex gap-3 sm:gap-4">
                        <x-heroicon-s-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ $desk['head_office']['address'] }}</span>
                    </p>

                    <p class="flex gap-3 sm:gap-4">
                        <x-heroicon-s-phone class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ $desk['head_office']['phone'] }}</span>
                    </p>

                    <p class="flex gap-3 sm:gap-4">
                        <x-heroicon-o-envelope class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-6 sm:w-6" aria-hidden="true" />
                        <span>{{ $desk['head_office']['email'] }}</span>
                    </p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-2 sm:mt-5 sm:gap-3">
                    <a href="{{ $desk['head_office']['call_href'] }}" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-md bg-gs-primary px-3 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:min-h-12 sm:gap-2 sm:px-4 sm:text-sm">
                        <x-heroicon-s-phone class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                        <span>{{ $desk['head_office']['actions']['call'] }}</span>
                    </a>

                    <a href="{{ $desk['head_office']['email_href'] }}" class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-md border-2 border-gs-primary/45 bg-white px-3 text-xs font-black text-gs-primary shadow-sm shadow-gs-navy/5 transition hover:border-gs-primary hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:min-h-12 sm:gap-2 sm:px-4 sm:text-sm">
                        <x-heroicon-o-envelope class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                        <span>{{ $desk['head_office']['actions']['email'] }}</span>
                    </a>
                </div>

                <div class="mt-4 flex gap-3 rounded-md bg-gs-concrete/60 p-3 text-gs-ink-muted sm:mt-7 sm:gap-4 sm:p-4">
                    <x-heroicon-o-information-circle class="mt-0.5 h-5 w-5 shrink-0 text-gs-grey sm:h-6 sm:w-6" aria-hidden="true" />
                    <div>
                        <p class="text-xs font-black leading-tight text-gs-navy sm:text-base">
                            {{ $desk['head_office']['notice']['title'] }}
                        </p>
                        <p class="mt-1 text-xs font-semibold leading-snug sm:mt-2 sm:text-base sm:leading-relaxed">
                            {{ $desk['head_office']['notice']['body'] }}
                        </p>
                    </div>
                </div>
            </aside>

            <form action="{{ route($routeLocale.'.contact.store', [], false) }}" method="post" class="order-2 rounded-lg border border-gs-concrete bg-white p-4 shadow-md shadow-gs-navy/8 sm:p-5 lg:order-1 lg:p-6" data-contact-message-form>
                @csrf

                <h2 class="text-lg font-black leading-tight tracking-normal text-gs-navy sm:text-2xl lg:text-[1.45rem]">
                    {{ $desk['form']['title'] }}
                </h2>

                @if (session('contact_message_status'))
                    <p class="mt-3 rounded-md border border-gs-success/25 bg-green-50 px-3 py-2 text-xs font-black text-gs-success sm:mt-4 sm:text-sm">
                        {{ session('contact_message_status') }}
                    </p>
                @endif

                <div class="mt-3 grid gap-2.5 sm:mt-4 sm:grid-cols-2 sm:gap-3">
                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['name'] }} <span class="text-gs-accent">*</span></span>
                        <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" class="{{ $inputClass }}" placeholder="{{ $desk['form']['placeholders']['name'] }}" required>
                    </label>

                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['phone'] }} <span class="text-gs-accent">*</span></span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="{{ $inputClass }}" placeholder="{{ $desk['form']['placeholders']['phone'] }}" required>
                    </label>

                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['email'] }}</span>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" class="{{ $inputClass }}" placeholder="{{ $desk['form']['placeholders']['email'] }}">
                    </label>

                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['agency'] }} <span class="text-gs-accent">*</span></span>
                        <span class="relative mt-1.5 block">
                            <select name="agency_slug" class="{{ $selectClass }} mt-0" required data-contact-agency-select>
                                <option value="" disabled @selected(! $selectedAgency)>{{ $desk['form']['placeholders']['agency'] }}</option>
                                @foreach ($desk['form']['agency_options'] as $option)
                                    <option value="{{ $option['value'] }}" @selected($selectedAgency === $option['value'])>{{ $option['label'] }}</option>
                                @endforeach
                            </select>
                            <x-heroicon-o-chevron-down class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gs-grey" aria-hidden="true" />
                        </span>
                    </label>

                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['subject'] }} <span class="text-gs-accent">*</span></span>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="{{ $inputClass }}" placeholder="{{ $desk['form']['placeholders']['subject'] }}" required>
                    </label>

                    <label>
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['type'] }} <span class="text-gs-accent">*</span></span>
                        <span class="relative mt-1.5 block">
                            <select name="request_type" class="{{ $selectClass }} mt-0" required>
                                <option value="" disabled @selected(! old('request_type'))>{{ $desk['form']['placeholders']['type'] }}</option>
                                @foreach ($desk['form']['type_options'] as $option)
                                    <option value="{{ $option }}" @selected(old('request_type') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            <x-heroicon-o-chevron-down class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gs-grey" aria-hidden="true" />
                        </span>
                    </label>

                    <label class="sm:col-span-2">
                        <span class="text-xs font-black text-gs-ink">{{ $desk['form']['fields']['message'] }} <span class="text-gs-accent">*</span></span>
                        <textarea name="message" class="{{ $textAreaClass }}" placeholder="{{ $desk['form']['placeholders']['message'] }}" required>{{ old('message') }}</textarea>
                    </label>
                </div>

                <p class="mt-3 flex items-start gap-2.5 text-xs font-semibold leading-snug text-gs-ink-muted sm:mt-4 sm:gap-3 sm:text-sm">
                    <x-heroicon-o-information-circle class="mt-0.5 h-4 w-4 shrink-0 text-gs-grey sm:h-5 sm:w-5" aria-hidden="true" />
                    <span>{{ $desk['form']['note'] }}</span>
                </p>

                <button type="submit" class="mt-3 inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-xs font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:mt-4 sm:min-h-12 sm:gap-3 sm:px-5 sm:text-base">
                    <x-heroicon-o-paper-airplane class="h-4 w-4 shrink-0 sm:h-5 sm:w-5" aria-hidden="true" />
                    <span>{{ $desk['form']['submit'] }}</span>
                </button>
            </form>
        </div>
    </section>

    <section class="bg-gs-wall px-3 pb-6 pt-3 sm:px-8 sm:pb-8 sm:pt-6 lg:px-16 lg:pb-10 lg:pt-8 xl:px-32" aria-labelledby="contact-faq-title" data-contact-faq>
        <div class="mx-auto max-w-none">
            <div class="text-center">
                <div class="mx-auto h-0.5 w-10 rounded-full bg-gs-accent sm:h-1 sm:w-14" aria-hidden="true"></div>

                <h2 id="contact-faq-title" class="mt-2 text-xl font-black leading-tight tracking-normal text-gs-navy sm:mt-3 sm:text-3xl lg:text-[2rem]">
                    {{ $faq['title'] }}
                </h2>
            </div>

            <div class="mt-3 grid gap-3 sm:mt-5 lg:grid-cols-2 lg:gap-5">
                @foreach (array_chunk($faq['items'], 4) as $columnIndex => $items)
                    <div class="overflow-hidden rounded-lg border border-gs-concrete/90 bg-white shadow-md shadow-gs-navy/8">
                        @foreach ($items as $index => $item)
                            @php($number = ($columnIndex * 4) + $index + 1)

                            <details @class(['group', 'border-t border-gs-concrete/80' => $index > 0])>
                                <summary class="flex min-h-11 cursor-pointer list-none items-center justify-between gap-3 px-4 py-2.5 text-left text-sm font-black leading-tight text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary sm:min-h-13 sm:px-5 sm:py-3.5 sm:text-base [&::-webkit-details-marker]:hidden">
                                    <span class="flex min-w-0 items-center gap-3">
                                        <span class="text-gs-primary">{{ $number }}.</span>
                                        <span>{{ $item['question'] }}</span>
                                    </span>
                                    <x-heroicon-o-chevron-down class="h-4 w-4 shrink-0 text-gs-grey transition group-open:rotate-180 sm:h-5 sm:w-5" aria-hidden="true" />
                                </summary>

                                <div class="px-4 pb-3 pl-[3.25rem] text-xs font-semibold leading-relaxed text-gs-ink-muted sm:px-5 sm:pb-4 sm:pl-[3.75rem] sm:text-sm">
                                    {{ $item['answer'] }}
                                </div>
                            </details>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
