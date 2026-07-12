@php
    $primaryPhoneDisplay = '+237 678 844 791';
    $primaryPhoneHref = 'tel:+237678844791';
    $whatsAppHref = 'https://wa.me/237678844791';
@endphp

<aside class="gs-top-strip bg-gs-navy" aria-label="{{ __('actions.quick_actions') }} GS AUTOBILAN">
    <div class="w-full overflow-hidden bg-gs-navy shadow-lg shadow-gs-navy/20">
        <div class="h-1.5 bg-gs-accent" aria-hidden="true"></div>
        <div class="h-px bg-white/80" aria-hidden="true"></div>

        <div class="grid bg-gs-navy text-white lg:flex lg:min-h-16 lg:items-center lg:justify-between lg:gap-6 lg:px-8">
            <div class="flex items-center gap-4 px-6 py-4 lg:px-0 lg:py-0">
                <span class="h-8 w-2 shrink-0 rounded-sm bg-gs-accent shadow-sm shadow-gs-accent/40" aria-hidden="true"></span>
                <p class="text-lg font-semibold leading-tight sm:text-xl">
                    {{ __('chrome.slogan') }}
                </p>
            </div>

            <div class="hidden min-w-0 flex-1 items-center gap-4 border-l border-white/25 pl-6 text-sm text-white/90 2xl:flex">
                <span class="h-3.5 w-3.5 shrink-0 rounded-full bg-gs-success shadow-sm shadow-gs-success/50" aria-hidden="true"></span>
                <p class="truncate">
                    <strong class="font-semibold text-white">{{ __('chrome.open_today') }}</strong>
                    <span class="text-white/80">— {{ __('chrome.hours_summary') }}</span>
                </p>
            </div>

            <div class="flex items-center justify-between gap-3 border-t border-white/20 px-4 py-3 sm:px-6 lg:border-l lg:border-t-0 lg:px-0 lg:py-0 lg:pl-6">
                <a href="{{ $primaryPhoneHref }}" class="inline-flex min-h-10 items-center gap-2 text-base font-semibold text-white transition hover:text-white/85 focus:outline-none focus:ring-2 focus:ring-white/60 focus:ring-offset-2 focus:ring-offset-gs-navy sm:gap-3">
                    <x-heroicon-o-phone class="h-5 w-5 text-white/85 sm:h-6 sm:w-6" aria-hidden="true" />
                    <span>{{ $primaryPhoneDisplay }}</span>
                </a>

                <span class="hidden h-10 w-px bg-white/25 sm:block" aria-hidden="true"></span>

                <a href="{{ $whatsAppHref }}" class="inline-flex min-h-10 items-center gap-2 rounded-full border border-white/80 px-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/60 focus:ring-offset-2 focus:ring-offset-gs-navy sm:px-4">
                    <svg class="h-6 w-6 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
                    </svg>
                    <span class="hidden min-[400px]:inline">{{ __('actions.whatsapp') }}</span>
                </a>

                <span class="hidden h-10 w-px bg-white/25 sm:block" aria-hidden="true"></span>

                @include('partials.language-switcher', ['variant' => 'strip', 'label' => __('actions.language')])
            </div>
        </div>
    </div>
</aside>
