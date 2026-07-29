<div class="gs-admin-login">
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <div class="gs-admin-login__grid">
        <section class="gs-admin-login__form-panel" aria-labelledby="gs-admin-login-title">
            @php
                $currentLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
                $languageHref = fn (string $locale): string => request()->fullUrlWithQuery(['locale' => $locale]);
            @endphp

            <nav class="gs-admin-login__language" aria-label="{{ __('admin_login.language.label') }}">
                <span class="gs-admin-login__language-label">{{ __('admin_login.language.label') }}</span>

                <span class="gs-admin-login__language-options">
                    <a
                        href="{{ $languageHref('fr') }}"
                        @if ($currentLocale === 'fr') aria-current="true" @endif
                        class="gs-admin-login__language-link"
                    >
                        FR
                    </a>

                    <a
                        href="{{ $languageHref('en') }}"
                        @if ($currentLocale === 'en') aria-current="true" @endif
                        class="gs-admin-login__language-link"
                    >
                        EN
                    </a>
                </span>
            </nav>

            <a class="gs-admin-login__brand" href="{{ url('/') }}">
                <span class="gs-admin-login__brand-mark" aria-hidden="true">
                    <img src="{{ asset('icon-192.png') }}" alt="" />
                </span>

                <span class="gs-admin-login__brand-copy">
                    <span class="gs-admin-login__brand-name">GS AUTOBILAN</span>
                    <span class="gs-admin-login__brand-label">{{ __('admin_login.brand_label') }}</span>
                </span>
            </a>

            <div class="gs-admin-login__intro">
                <p class="gs-admin-login__eyebrow">{{ __('admin_login.eyebrow') }}</p>
                <h1 id="gs-admin-login-title">{{ __('admin_login.heading') }}</h1>
                <p>
                    {{ __('admin_login.intro') }}
                </p>
            </div>

            <div class="gs-admin-login__form">
                {{ $this->content }}
            </div>

            <div class="gs-admin-login__footer">
                <span class="gs-admin-login__footer-icon" aria-hidden="true">
                    <x-heroicon-m-shield-check />
                </span>
                <span>{{ __('admin_login.footer') }}</span>
            </div>
        </section>

        <aside class="gs-admin-login__visual" aria-label="{{ __('admin_login.visual.label') }}">
            <img
                src="{{ asset('images/homepage/hero-1.webp') }}"
                alt="{{ __('admin_login.visual.alt') }}"
            />

            <div class="gs-admin-login__visual-shade" aria-hidden="true"></div>

            <div class="gs-admin-login__visual-content">
                <p class="gs-admin-login__eyebrow">{{ __('admin_login.visual.eyebrow') }}</p>
                <h2>{{ __('admin_login.visual.heading') }}</h2>

                <div class="gs-admin-login__metrics" aria-label="{{ __('admin_login.metrics.label') }}">
                    <div>
                        <strong>{{ __('admin_login.metrics.hours.value') }}</strong>
                        <span>{{ __('admin_login.metrics.hours.label') }}</span>
                    </div>

                    <div>
                        <strong>{{ __('admin_login.metrics.agencies.value') }}</strong>
                        <span>{{ __('admin_login.metrics.agencies.label') }}</span>
                    </div>

                    <div>
                        <strong>{{ __('admin_login.metrics.records.value') }}</strong>
                        <span>{{ __('admin_login.metrics.records.label') }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <x-filament-actions::modals />

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
