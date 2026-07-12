@props([
    'items' => [],
])

<div {{ $attributes->merge(['class' => 'divide-y divide-gs-concrete rounded-lg border border-gs-concrete bg-white shadow-sm shadow-gs-navy/5']) }}>
    @foreach ($items as $item)
        <details class="group">
            <summary class="flex min-h-14 cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 text-left text-gs-body font-bold text-gs-navy transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gs-primary">
                <span>{{ $item['question'] ?? '' }}</span>
                <x-heroicon-o-chevron-down class="h-5 w-5 shrink-0 text-gs-accent transition group-open:rotate-180" aria-hidden="true" />
            </summary>
            <div class="px-5 pb-5 text-gs-small leading-relaxed text-gs-grey">
                @if (($item['answer'] ?? null) instanceof \Illuminate\Support\HtmlString)
                    {!! $item['answer'] !!}
                @else
                    <p>{{ $item['answer'] ?? '' }}</p>
                @endif
            </div>
        </details>
    @endforeach

    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>
