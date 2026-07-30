@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $roleItems = $this->roleItems();
    $latestUsers = $this->latestUsers();
    $latestActivities = $this->latestActivities();
    $attentionItems = $this->attentionItems();
@endphp

<x-filament-panels::page>
    <div class="gs-operations gs-users-settings" data-admin-users-settings-page>
        <section class="gs-operations-command" aria-labelledby="gs-users-settings-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_users_settings.command.eyebrow') }}</span>
                <h2 id="gs-users-settings-command-title">{{ __('admin_users_settings.command.heading') }}</h2>
                <p>{{ __('admin_users_settings.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            @if ($link['icon'] === 'cog')
                                <x-heroicon-o-cog-6-tooth />
                            @else
                                <x-heroicon-o-users />
                            @endif
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gs-operations-summary" aria-label="{{ __('admin_users_settings.summary.label') }}">
            @foreach ($summaryCards as $card)
                <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                    <span class="gs-operations-summary-card__icon" aria-hidden="true">
                        @switch($card['icon'])
                            @case('shield')
                                <x-heroicon-o-shield-check />
                                @break

                            @case('key')
                                <x-heroicon-o-key />
                                @break

                            @case('cog')
                                <x-heroicon-o-cog-6-tooth />
                                @break

                            @default
                                <x-heroicon-o-users />
                        @endswitch
                    </span>

                    <span class="gs-operations-summary-card__body">
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <small>{{ $card['description'] }}</small>
                    </span>
                </article>
            @endforeach
        </section>

        <div class="gs-operations-layout">
            <section class="gs-operations-panel gs-operations-panel--actions">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-squares-2x2 />
                    </span>
                    <div>
                        <h3>{{ __('admin_users_settings.quick_links.heading') }}</h3>
                        <p>{{ __('admin_users_settings.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    @switch($link['icon'])
                                        @case('cog')
                                            <x-heroicon-o-cog-6-tooth />
                                            @break

                                        @case('clipboard')
                                            <x-heroicon-o-clipboard-document-list />
                                            @break

                                        @default
                                            <x-heroicon-o-users />
                                    @endswitch
                                </span>
                                <span class="gs-operations-quick-card__copy">
                                    <strong>{{ $link['label'] }}</strong>
                                    <small>{{ $link['description'] }}</small>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-lock-closed aria-hidden="true" />
                        <span>{{ __('admin_users_settings.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-shield-check />
                    </span>
                    <div>
                        <h3>{{ __('admin_users_settings.roles.heading') }}</h3>
                        <p>{{ __('admin_users_settings.roles.description') }}</p>
                    </div>
                </div>

                <div class="gs-operations-workload-list">
                    @foreach ($roleItems as $item)
                        <article class="gs-operations-workload-item">
                            <div class="gs-operations-workload-item__top">
                                <strong>{{ $item['label'] }}</strong>
                                <span>{{ number_format($item['count']) }}</span>
                            </div>
                            <div class="gs-operations-meter" aria-hidden="true">
                                <span style="width: {{ $item['percent'] }}%"></span>
                            </div>
                            <small>{{ $item['description'] }}</small>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="gs-operations-feed-grid">
            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-user-group />
                    </span>
                    <div>
                        <h3>{{ __('admin_users_settings.latest_users.heading') }}</h3>
                        <p>{{ __('admin_users_settings.latest_users.description') }}</p>
                    </div>
                </div>

                @if ($latestUsers->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestUsers as $user)
                            <a href="{{ $this->userUrl($user) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->userTone($user) }}">
                                    <x-heroicon-o-user-circle aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $this->userTitle($user) }}</span>
                                    <span class="gs-operations-feed-item__meta">{{ $this->userMeta($user) }}</span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->userTone($user) }}">
                                    {{ $this->userStatusLabel($user) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-users aria-hidden="true" />
                        <span>{{ __('admin_users_settings.latest_users.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-clipboard-document-list />
                    </span>
                    <div>
                        <h3>{{ __('admin_users_settings.latest_activity.heading') }}</h3>
                        <p>{{ __('admin_users_settings.latest_activity.description') }}</p>
                    </div>
                </div>

                @if ($latestActivities->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestActivities as $activity)
                            <a href="{{ \App\Filament\Resources\ActivityResource::getUrl() }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->activityTone($activity) }}">
                                    <x-heroicon-o-clipboard-document-list aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $this->activityDescription($activity) }}</span>
                                    <span class="gs-operations-feed-item__meta">{{ $this->activityMeta($activity) }}</span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->activityTone($activity) }}">
                                    {{ $this->activityStatusLabel($activity) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-clipboard-document-list aria-hidden="true" />
                        <span>{{ __('admin_users_settings.latest_activity.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>

        <section class="gs-operations-panel gs-operations-panel--feed">
            <div class="gs-operations-panel__header">
                <span class="gs-operations-panel__icon" aria-hidden="true">
                    <x-heroicon-o-exclamation-triangle />
                </span>
                <div>
                    <h3>{{ __('admin_users_settings.attention.heading') }}</h3>
                    <p>{{ __('admin_users_settings.attention.description') }}</p>
                </div>
            </div>

            @if ($attentionItems !== [])
                <div class="gs-operations-feed">
                    @foreach ($attentionItems as $item)
                        <a href="{{ $item['href'] }}" class="gs-operations-feed-item">
                            <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $item['tone'] }}">
                                @switch($item['icon'])
                                    @case('building')
                                        <x-heroicon-o-building-office-2 aria-hidden="true" />
                                        @break

                                    @case('shield')
                                        <x-heroicon-o-shield-exclamation aria-hidden="true" />
                                        @break

                                    @case('clipboard')
                                        <x-heroicon-o-clipboard-document-list aria-hidden="true" />
                                        @break

                                    @default
                                        <x-heroicon-o-lock-closed aria-hidden="true" />
                                @endswitch
                            </span>

                            <span class="gs-operations-feed-item__body">
                                <span class="gs-operations-feed-item__title">{{ $item['label'] }}</span>
                                <span class="gs-operations-feed-item__meta">{{ $item['description'] }}</span>
                            </span>

                            <span class="gs-operations-status gs-operations-tone-{{ $item['tone'] }}">
                                {{ number_format($item['count']) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="gs-operations-empty">
                    <x-heroicon-o-check-circle aria-hidden="true" />
                    <span>{{ __('admin_users_settings.attention.empty') }}</span>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
