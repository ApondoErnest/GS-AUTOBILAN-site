@props([
    'name',
    'address' => null,
    'hours' => null,
    'phone' => null,
    'mapHref' => null,
    'callHref' => null,
    'bookHref' => null,
    'whatsappHref' => null,
])

<article {{ $attributes->merge(['class' => 'group relative overflow-hidden rounded-lg border border-gs-concrete bg-white p-5 shadow-sm shadow-gs-navy/5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-gs-navy/10']) }}>
    <span class="absolute left-0 top-5 h-16 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>

    <div class="flex gap-4 pl-2">
        <span class="mt-1 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gs-soft text-gs-primary">
            <x-heroicon-o-map-pin class="h-6 w-6" aria-hidden="true" />
        </span>

        <div class="min-w-0">
            <h3 class="text-gs-h3 font-bold text-gs-navy">{{ $name }}</h3>

            @if ($address)
                <p class="mt-2 text-gs-small text-gs-grey">{{ $address }}</p>
            @endif
        </div>
    </div>

    <div class="mt-5 space-y-3 text-gs-small text-gs-ink-muted">
        @if ($hours)
            <p class="flex gap-3">
                <x-heroicon-o-clock class="mt-0.5 h-5 w-5 shrink-0 text-gs-primary" aria-hidden="true" />
                <span>{{ $hours }}</span>
            </p>
        @endif

        @if ($phone)
            <p class="flex gap-3">
                <x-heroicon-o-phone class="mt-0.5 h-5 w-5 shrink-0 text-gs-primary" aria-hidden="true" />
                <span>{{ $phone }}</span>
            </p>
        @endif

        @if ($slot->isNotEmpty())
            <div class="leading-relaxed">
                {{ $slot }}
            </div>
        @endif
    </div>

    @if ($mapHref || $callHref || $bookHref || $whatsappHref)
        <div class="mt-5 flex flex-wrap gap-3">
            @if ($bookHref)
                <a href="{{ $bookHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-gs-small font-bold text-white transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-calendar-days class="h-4 w-4" aria-hidden="true" />
                    <span>{{ __('actions.book') }}</span>
                </a>
            @endif

            @if ($mapHref)
                <a href="{{ $mapHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-primary px-4 text-gs-small font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-map-pin class="h-4 w-4" aria-hidden="true" />
                    <span>{{ __('actions.directions') }}</span>
                </a>
            @endif

            @if ($callHref)
                <a href="{{ $callHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-primary px-4 text-gs-small font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <x-heroicon-o-phone class="h-4 w-4" aria-hidden="true" />
                    <span>{{ __('actions.call') }}</span>
                </a>
            @endif

            @if ($whatsappHref)
                <a href="{{ $whatsappHref }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-gs-success/40 px-4 text-gs-small font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    <svg class="h-5 w-5 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                    </svg>
                    <span>{{ __('actions.whatsapp') }}</span>
                </a>
            @endif
        </div>
    @endif
</article>
