<nav class="gs-fabs fixed inset-x-3 bottom-3 z-40 grid grid-cols-2 gap-3 sm:inset-auto sm:bottom-6 sm:right-6 sm:flex sm:flex-col sm:items-end" style="padding-bottom: env(safe-area-inset-bottom)" aria-label="{{ __('actions.quick_actions') }}">
    <a href="tel:+237678844791" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/80 bg-gs-navy px-4 text-sm font-bold text-white shadow-xl shadow-gs-navy/25 transition hover:bg-gs-bay focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:min-w-40 sm:justify-start">
        <x-heroicon-o-phone class="h-5 w-5" aria-hidden="true" />
        <span>{{ __('actions.call') }}</span>
    </a>

    <a href="https://wa.me/237678844791" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-gs-success/30 bg-white px-4 text-sm font-bold text-gs-navy shadow-xl shadow-gs-navy/20 transition hover:bg-gs-soft focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2 sm:min-w-40 sm:justify-start">
        <svg class="h-6 w-6 text-gs-success" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M7.2 19.2 3.5 20.5l1.2-3.8a8.5 8.5 0 1 1 2.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
            <path d="M8.9 8.3c.2-.5.4-.5.7-.5h.5c.2 0 .4 0 .5.4l.7 1.7c.1.3 0 .5-.2.7l-.4.5c.8 1.3 1.8 2.2 3.1 2.8l.6-.6c.2-.2.4-.3.7-.2l1.6.8c.4.2.4.4.4.7 0 .9-.7 1.8-1.7 1.8-2.7 0-7.5-3.5-7.5-6.9 0-.5.1-.8.3-1.2Z" fill="currentColor" />
        </svg>
        <span>{{ __('actions.whatsapp') }}</span>
    </a>
</nav>
