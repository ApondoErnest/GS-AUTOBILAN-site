@php
    use App\Filament\Support\AdminChrome;

    $context = AdminChrome::context();
    $currentLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $languageHref = fn (string $locale): string => request()->fullUrlWithQuery(['locale' => $locale]);
@endphp

@if ($context)
    <div class="gs-admin-topbar-controls">
        <div class="gs-admin-topbar-chip gs-admin-topbar-chip--status">
            <span class="gs-admin-topbar-chip__icon" aria-hidden="true">
                <x-heroicon-m-shield-check />
            </span>

            <span class="gs-admin-topbar-chip__copy">
                <span>{{ __('admin_chrome.topbar.status_label') }}</span>
                <strong>{{ __('admin_chrome.topbar.status_value') }}</strong>
            </span>
        </div>

        <div class="gs-admin-topbar-chip gs-admin-topbar-chip--role">
            <span class="gs-admin-topbar-chip__icon" aria-hidden="true">
                <x-heroicon-o-user-circle />
            </span>

            <span class="gs-admin-topbar-chip__copy">
                <span>{{ __('admin_chrome.topbar.role_label') }}</span>
                <strong>{{ $context['roleLabel'] }}</strong>
            </span>
        </div>

        <div class="gs-admin-topbar-chip gs-admin-topbar-chip--scope">
            <span class="gs-admin-topbar-chip__icon" aria-hidden="true">
                <x-heroicon-o-building-office-2 />
            </span>

            <span class="gs-admin-topbar-chip__copy">
                <span>{{ __('admin_chrome.topbar.scope_label') }}</span>
                <strong title="{{ $context['scopeLabel'] }}">{{ $context['scopeLabel'] }}</strong>
            </span>
        </div>

        <div class="gs-admin-topbar-chip gs-admin-topbar-chip--updated">
            <span class="gs-admin-topbar-chip__icon" aria-hidden="true">
                <x-heroicon-o-clock />
            </span>

            <span class="gs-admin-topbar-chip__copy">
                <span>{{ __('admin_chrome.topbar.updated_label') }}</span>
                <strong>{{ $context['updatedAtLabel'] }}</strong>
            </span>
        </div>

        <nav class="gs-admin-topbar-language" aria-label="{{ __('admin_chrome.topbar.language_label') }}">
            <span class="gs-admin-topbar-language__label">
                <x-heroicon-o-language aria-hidden="true" />
                <span>{{ __('admin_chrome.topbar.language_label') }}</span>
            </span>

            <span class="gs-admin-topbar-language__options">
                <a
                    href="{{ $languageHref('fr') }}"
                    @if ($currentLocale === 'fr') aria-current="true" @endif
                    class="gs-admin-topbar-language__link"
                >
                    FR
                </a>

                <a
                    href="{{ $languageHref('en') }}"
                    @if ($currentLocale === 'en') aria-current="true" @endif
                    class="gs-admin-topbar-language__link"
                >
                    EN
                </a>
            </span>
        </nav>
    </div>
@endif
