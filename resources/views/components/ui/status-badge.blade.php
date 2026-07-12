@props([
    'label',
    'tone' => 'neutral',
])

@php
    $toneClasses = [
        'success' => 'border-gs-success/25 bg-green-50 text-gs-success',
        'warning' => 'border-gs-warning/35 bg-yellow-50 text-amber-700',
        'danger' => 'border-gs-danger/25 bg-red-50 text-gs-danger',
        'info' => 'border-gs-primary/25 bg-gs-soft text-gs-primary',
        'neutral' => 'border-gs-concrete bg-white text-gs-ink-muted',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex min-h-8 items-center gap-2 rounded-full border px-3 text-gs-small font-bold ' . ($toneClasses[$tone] ?? $toneClasses['neutral'])]) }}>
    <span class="h-2 w-2 rounded-full bg-current" aria-hidden="true"></span>
    <span>{{ $label }}</span>
</span>
