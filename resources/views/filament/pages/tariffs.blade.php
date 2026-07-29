@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $readinessItems = $this->readinessItems();
    $latestTariffs = $this->latestTariffs();
    $attentionItems = $this->attentionItems();
@endphp

<x-filament-panels::page>
    <div class="gs-operations gs-tariffs" data-admin-tariffs-page>
        <section class="gs-operations-command" aria-labelledby="gs-tariffs-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_tariffs.command.eyebrow') }}</span>
                <h2 id="gs-tariffs-command-title">{{ __('admin_tariffs.command.heading') }}</h2>
                <p>{{ __('admin_tariffs.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            <x-heroicon-o-banknotes />
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gs-operations-summary" aria-label="{{ __('admin_tariffs.summary.label') }}">
            @foreach ($summaryCards as $card)
                <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                    <span class="gs-operations-summary-card__icon" aria-hidden="true">
                        @switch($card['icon'])
                            @case('banknotes')
                                <x-heroicon-o-banknotes />
                                @break

                            @case('clock')
                                <x-heroicon-o-clock />
                                @break

                            @case('squares')
                                <x-heroicon-o-squares-2x2 />
                                @break

                            @default
                                <x-heroicon-o-eye />
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
                        <h3>{{ __('admin_tariffs.quick_links.heading') }}</h3>
                        <p>{{ __('admin_tariffs.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    <x-heroicon-o-banknotes />
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
                        <span>{{ __('admin_tariffs.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-chart-bar-square />
                    </span>
                    <div>
                        <h3>{{ __('admin_tariffs.readiness.heading') }}</h3>
                        <p>{{ __('admin_tariffs.readiness.description') }}</p>
                    </div>
                </div>

                <div class="gs-operations-workload-list">
                    @foreach ($readinessItems as $item)
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
                        <x-heroicon-o-banknotes />
                    </span>
                    <div>
                        <h3>{{ __('admin_tariffs.latest.heading') }}</h3>
                        <p>{{ __('admin_tariffs.latest.description') }}</p>
                    </div>
                </div>

                @if ($latestTariffs->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestTariffs as $tariff)
                            <a href="{{ $this->tariffUrl($tariff) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->tariffTone($tariff) }}">
                                    <x-heroicon-o-truck aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $this->tariffTitle($tariff) }}</span>
                                    <span class="gs-operations-feed-item__meta">
                                        {{ $this->tariffMeta($tariff) }}
                                        <span>{{ $this->tariffPrice($tariff) }}</span>
                                    </span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->tariffTone($tariff) }}">
                                    {{ $this->tariffStatusLabel($tariff) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_tariffs.latest.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-exclamation-triangle />
                    </span>
                    <div>
                        <h3>{{ __('admin_tariffs.attention.heading') }}</h3>
                        <p>{{ __('admin_tariffs.attention.description') }}</p>
                    </div>
                </div>

                @if ($attentionItems !== [])
                    <div class="gs-operations-feed">
                        @foreach ($attentionItems as $item)
                            <a href="{{ $item['href'] }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $item['tone'] }}">
                                    @switch($item['icon'])
                                        @case('banknotes')
                                            <x-heroicon-o-banknotes aria-hidden="true" />
                                            @break

                                        @case('eye-slash')
                                            <x-heroicon-o-eye-slash aria-hidden="true" />
                                            @break

                                        @case('calendar')
                                            <x-heroicon-o-calendar-days aria-hidden="true" />
                                            @break

                                        @default
                                            <x-heroicon-o-clock aria-hidden="true" />
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
                        <span>{{ __('admin_tariffs.attention.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-filament-panels::page>
