@props(['name'])

@switch($name)
    @case('pickup')
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M10 38h30V24H10v14Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M40 30h8l7 8v7H40V30Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M14 24h10M28 24h12M10 45h45" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="21" cy="45" r="5" stroke="currentColor" stroke-width="3" />
            <circle cx="46" cy="45" r="5" stroke="currentColor" stroke-width="3" />
        </svg>
        @break

    @case('taxi')
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M22 19h20l3 8H19l3-8Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M13 31h38l4 6v11H9V37l4-6Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M26 14h12l2 5H24l2-5ZM15 48v4M49 48v4M17 39h4M43 39h4M27 39h2M35 39h2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
        </svg>
        @break

    @case('bus')
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <rect x="11" y="15" width="42" height="33" rx="5" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M18 23h28M18 31h28M18 39h8M38 39h8M18 48v5M46 48v5" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="23" cy="48" r="4" stroke="currentColor" stroke-width="3" />
            <circle cx="41" cy="48" r="4" stroke="currentColor" stroke-width="3" />
        </svg>
        @break

    @case('truck')
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M9 38h30V18H9v20ZM39 27h9l7 9v10H39V27Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M9 46h46" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="21" cy="46" r="5" stroke="currentColor" stroke-width="3" />
            <circle cx="46" cy="46" r="5" stroke="currentColor" stroke-width="3" />
        </svg>
        @break

    @case('machinery')
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M14 45h27M18 45l6-17h14l8 17" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            <path d="M38 28l10-10 8 8-10 10M48 18l-5-5M30 28v-8M25 20h11" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            <path d="M17 51h28" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="22" cy="45" r="4" stroke="currentColor" stroke-width="3" />
            <circle cx="34" cy="45" r="4" stroke="currentColor" stroke-width="3" />
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['class' => 'h-10 w-10', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M15 37 20 24c.8-2.2 2.7-3.6 5-3.6h14c2.3 0 4.2 1.4 5 3.6l5 13" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            <path d="M10 37h44v12H10V37Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M17 49v4M47 49v4M19 43h4M41 43h4M24 29h16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
        </svg>
@endswitch
