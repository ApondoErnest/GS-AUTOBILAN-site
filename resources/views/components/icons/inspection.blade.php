@props(['name'])

@switch($name)
    @case('brake')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M32 7a25 25 0 1 0 25 25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            <path d="M32 7v16" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <path d="M11 32h17" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="32" cy="32" r="12" stroke="currentColor" stroke-width="3" />
            <circle cx="32" cy="32" r="4" stroke="currentColor" stroke-width="3" />
            <path d="M32 20v-5M32 49v-5M20 32h-5M49 32h-5M23.5 23.5 20 20M44 44l-3.5-3.5M40.5 23.5 44 20M20 44l3.5-3.5" stroke="currentColor" stroke-linecap="round" stroke-width="2.6" />
            <path d="M53 24c3 3 4.5 7 4 11" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
        </svg>
        @break

    @case('suspension')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <g transform="rotate(28 32 32)">
                <path d="M31 7v8M31 49v8" stroke="currentColor" stroke-linecap="round" stroke-width="4" />
                <path d="M23 14h16M23 50h16" stroke="currentColor" stroke-linecap="round" stroke-width="4" />
                <path d="M39 18c-13 0-13 6 0 6s13 6 0 6-13 6 0 6 13 6 0 6-13 6 0 6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                <path d="M23 18c13 0 13 6 0 6s-13 6 0 6 13 6 0 6-13 6 0 6 13 6 0 6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
            </g>
        </svg>
        @break

    @case('headlight')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M27 20h9c8 0 15 5 15 12s-7 12-15 12h-9c-2.8 0-5-2.2-5-5V25c0-2.8 2.2-5 5-5Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M31 21c-3.5 5.6-3.5 16.4 0 22" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <path d="M9 23h9M8 29h9M8 35h9M9 41h9" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
        </svg>
        @break

    @case('tire')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <g transform="rotate(12 32 32)">
                <ellipse cx="32" cy="32" rx="16" ry="25" stroke="currentColor" stroke-width="3" />
                <ellipse cx="32" cy="32" rx="9" ry="18" stroke="currentColor" stroke-width="3" />
                <path d="M24 10c-5 4-8 12-8 22s3 18 8 22M40 10c5 4 8 12 8 22s-3 18-8 22" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
                <path d="M25 17 18 21M25 27l-9 4M25 37l-9 4M25 47l-7 4M39 17l7 4M39 27l9 4M39 37l9 4M39 47l7 4" stroke="currentColor" stroke-linecap="round" stroke-width="2.4" />
            </g>
        </svg>
        @break

    @case('id-card')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <rect x="9" y="14" width="46" height="36" rx="4" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <circle cx="25" cy="28" r="5" stroke="currentColor" stroke-width="3" />
            <path d="M16 43c2-6 16-6 18 0" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <path d="M39 24h10M39 32h10M39 40h7" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
        </svg>
        @break

    @case('eye')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <path d="M8 32s9-14 24-14 24 14 24 14-9 14-24 14S8 32 8 32Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <circle cx="32" cy="32" r="9" stroke="currentColor" stroke-width="3" />
            <circle cx="35" cy="29" r="3" fill="currentColor" />
        </svg>
        @break

    @case('steering')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <circle cx="32" cy="32" r="24" stroke="currentColor" stroke-width="3" />
            <path d="M14 32c5-8 31-8 36 0" stroke="currentColor" stroke-linecap="round" stroke-width="3" />
            <circle cx="32" cy="39" r="5" stroke="currentColor" stroke-width="3" />
            <path d="M28 40 17 48M36 40l11 8M32 34V20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
        </svg>
        @break

    @case('clipboard')
        <svg {{ $attributes->merge(['class' => 'h-16 w-16', 'aria-hidden' => 'true']) }} viewBox="0 0 64 64" fill="none">
            <rect x="15" y="13" width="34" height="42" rx="4" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="M25 13c0-3 2-5 7-5s7 2 7 5v4H25v-4Z" stroke="currentColor" stroke-linejoin="round" stroke-width="3" />
            <path d="m23 29 3 3 5-6M36 30h7M23 40l3 3 5-6M36 41h7" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
        </svg>
        @break
@endswitch
