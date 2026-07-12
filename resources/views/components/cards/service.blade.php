@props([
    'title',
    'description' => null,
    'icon' => 'truck',
    'href' => null,
    'cta' => null,
])

@php
    $iconComponent = str_starts_with($icon, 'heroicon-') ? $icon : "heroicon-o-{$icon}";
@endphp

<article {{ $attributes->merge(['class' => 'group relative overflow-hidden rounded-lg border border-gs-concrete bg-white p-5 shadow-sm shadow-gs-navy/5 transition hover:-translate-y-0.5 hover:border-gs-primary/30 hover:shadow-lg hover:shadow-gs-navy/10']) }}>
    <span class="absolute left-0 top-5 h-14 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>

    <div class="flex items-start gap-4 pl-2">
        <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-gs-soft text-gs-primary">
            <x-dynamic-component :component="$iconComponent" class="h-7 w-7" aria-hidden="true" />
        </span>

        <div class="min-w-0">
            <h3 class="text-gs-h3 font-bold text-gs-navy">{{ $title }}</h3>

            @if ($description)
                <p class="mt-2 text-gs-small leading-relaxed text-gs-grey">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if ($slot->isNotEmpty())
        <div class="mt-4 pl-2 text-gs-small leading-relaxed text-gs-ink-muted">
            {{ $slot }}
        </div>
    @endif

    @if ($href)
        <a href="{{ $href }}" class="mt-5 inline-flex min-h-10 items-center gap-2 pl-2 text-gs-small font-bold text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
            <span>{{ $cta ?? __('actions.learn_more') }}</span>
            <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
        </a>
    @endif
</article>
