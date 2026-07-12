@props([
    'actions' => [],
    'align' => 'start',
])

@php
    $alignClass = [
        'center' => 'justify-center',
        'end' => 'justify-end',
        'between' => 'justify-between',
        'start' => 'justify-start',
    ][$align] ?? 'justify-start';
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col gap-3 sm:flex-row sm:flex-wrap {$alignClass}"]) }}>
    @foreach ($actions as $action)
        @php
            $variant = $action['variant'] ?? 'primary';
            $icon = $action['icon'] ?? null;
            $iconComponent = $icon ? (str_starts_with($icon, 'heroicon-') ? $icon : "heroicon-o-{$icon}") : null;
            $classes = $variant === 'outline'
                ? 'border border-gs-primary bg-white text-gs-navy hover:bg-gs-soft'
                : 'border border-gs-primary bg-gs-primary text-white shadow-md shadow-gs-primary/20 hover:bg-gs-navy';
        @endphp

        <a href="{{ $action['href'] ?? '#' }}" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-md px-5 text-gs-small font-bold transition focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 {{ $classes }}">
            @if ($iconComponent)
                <x-dynamic-component :component="$iconComponent" class="h-5 w-5" aria-hidden="true" />
            @endif
            <span>{{ $action['label'] ?? '' }}</span>
            @if ($action['chevron'] ?? false)
                <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
            @endif
        </a>
    @endforeach

    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>
