<button
    type="button"
    class="gs-back-to-top fixed bottom-24 right-4 z-40 inline-flex h-14 w-14 items-center justify-center rounded-full border border-white/80 bg-gs-navy text-white shadow-2xl shadow-gs-navy/30 transition hover:bg-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:bottom-40 sm:right-6 lg:hidden"
    data-back-to-top
    aria-label="{{ __('actions.back_to_top') }}"
    aria-hidden="true"
    tabindex="-1"
>
    <span class="absolute inset-1 rounded-full border border-white/15" aria-hidden="true"></span>
    <x-heroicon-o-arrow-up class="relative h-6 w-6" aria-hidden="true" />
    <span class="sr-only">{{ __('actions.back_to_top') }}</span>
</button>
