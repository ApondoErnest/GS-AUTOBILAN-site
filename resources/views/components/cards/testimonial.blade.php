@props([
    'quote',
    'name' => null,
    'role' => null,
    'rating' => 5,
])

<figure {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-lg border border-gs-concrete bg-white p-5 shadow-sm shadow-gs-navy/5']) }}>
    <span class="absolute left-0 top-5 h-14 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>

    <div class="pl-2">
        <div class="flex gap-1 text-gs-warning" aria-label="{{ $rating }} / 5">
            @for ($i = 1; $i <= 5; $i++)
                <x-heroicon-s-star @class(['h-5 w-5', 'opacity-30' => $i > $rating]) aria-hidden="true" />
            @endfor
        </div>

        <blockquote class="mt-4 text-gs-body leading-relaxed text-gs-ink">
            “{{ $quote }}”
        </blockquote>

        @if ($name || $role)
            <figcaption class="mt-5 border-t border-gs-concrete pt-4">
                @if ($name)
                    <p class="font-bold text-gs-navy">{{ $name }}</p>
                @endif
                @if ($role)
                    <p class="mt-1 text-gs-small text-gs-ink-muted">{{ $role }}</p>
                @endif
            </figcaption>
        @endif
    </div>
</figure>
