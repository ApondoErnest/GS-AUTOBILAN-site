@props([
    'title',
    'excerpt' => null,
    'href' => '#',
    'category' => null,
    'date' => null,
    'image' => null,
])

<article {{ $attributes->merge(['class' => 'group overflow-hidden rounded-lg border border-gs-concrete bg-white shadow-sm shadow-gs-navy/5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-gs-navy/10']) }}>
    @if ($image)
        <a href="{{ $href }}" class="block aspect-[16/9] overflow-hidden bg-gs-soft">
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        </a>
    @endif

    <div class="relative p-5">
        <span class="absolute left-0 top-5 h-14 w-2 rounded-r-sm bg-gs-accent" aria-hidden="true"></span>

        <div class="pl-2">
            @if ($category || $date)
                <div class="mb-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-gs-small text-gs-ink-muted">
                    @if ($category)
                        <span class="font-bold uppercase text-gs-primary">{{ $category }}</span>
                    @endif
                    @if ($date)
                        <span>{{ $date }}</span>
                    @endif
                </div>
            @endif

            <h3 class="text-gs-h3 font-bold leading-snug text-gs-navy">
                <a href="{{ $href }}" class="transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                    {{ $title }}
                </a>
            </h3>

            @if ($excerpt)
                <p class="mt-3 text-gs-small leading-relaxed text-gs-grey">{{ $excerpt }}</p>
            @endif

            <a href="{{ $href }}" class="mt-5 inline-flex min-h-10 items-center gap-2 text-gs-small font-bold text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                <span>{{ __('actions.learn_more') }}</span>
                <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
            </a>
        </div>
    </div>
</article>
