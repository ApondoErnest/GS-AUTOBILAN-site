@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $readinessItems = $this->readinessItems();
    $feedPanels = $this->feedPanels();
    $attentionItems = $this->attentionItems();
@endphp

<x-filament-panels::page>
    <div class="gs-operations gs-agencies-services" data-admin-agencies-services-page>
        <section class="gs-operations-command" aria-labelledby="gs-agencies-services-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_agencies_services.command.eyebrow') }}</span>
                <h2 id="gs-agencies-services-command-title">{{ __('admin_agencies_services.command.heading') }}</h2>
                <p>{{ __('admin_agencies_services.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            @switch($link['icon'])
                                @case('wrench')
                                    <x-heroicon-o-wrench-screwdriver />
                                    @break

                                @default
                                    <x-heroicon-o-building-office-2 />
                            @endswitch
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        @if ($summaryCards !== [])
            <section class="gs-operations-summary" aria-label="{{ __('admin_agencies_services.summary.label') }}">
                @foreach ($summaryCards as $card)
                    <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                        <span class="gs-operations-summary-card__icon" aria-hidden="true">
                            @switch($card['icon'])
                                @case('check')
                                    <x-heroicon-o-check-circle />
                                    @break

                                @case('wrench')
                                    <x-heroicon-o-wrench-screwdriver />
                                    @break

                                @case('eye-slash')
                                    <x-heroicon-o-eye-slash />
                                    @break

                                @default
                                    <x-heroicon-o-building-office-2 />
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
        @endif

        <div class="gs-operations-layout">
            <section class="gs-operations-panel gs-operations-panel--actions">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-squares-2x2 />
                    </span>
                    <div>
                        <h3>{{ __('admin_agencies_services.quick_links.heading') }}</h3>
                        <p>{{ __('admin_agencies_services.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    @switch($link['icon'])
                                        @case('wrench')
                                            <x-heroicon-o-wrench-screwdriver />
                                            @break

                                        @default
                                            <x-heroicon-o-building-office-2 />
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
                        <span>{{ __('admin_agencies_services.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-chart-bar-square />
                    </span>
                    <div>
                        <h3>{{ __('admin_agencies_services.readiness.heading') }}</h3>
                        <p>{{ __('admin_agencies_services.readiness.description') }}</p>
                    </div>
                </div>

                @if ($readinessItems !== [])
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
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_agencies_services.readiness.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>

        <div class="gs-operations-feed-grid {{ count($feedPanels) === 1 ? 'gs-operations-feed-grid--single' : '' }}">
            @forelse ($feedPanels as $panel)
                <section class="gs-operations-panel gs-operations-panel--feed">
                    <div class="gs-operations-panel__header">
                        <span class="gs-operations-panel__icon" aria-hidden="true">
                            @switch($panel['icon'])
                                @case('wrench')
                                    <x-heroicon-o-wrench-screwdriver />
                                    @break

                                @default
                                    <x-heroicon-o-building-office-2 />
                            @endswitch
                        </span>
                        <div>
                            <h3>{{ $panel['heading'] }}</h3>
                            <p>{{ $panel['description'] }}</p>
                        </div>
                    </div>

                    @if ($panel['items']->isNotEmpty())
                        <div class="gs-operations-feed">
                            @foreach ($panel['items'] as $item)
                                <a href="{{ $this->itemUrl($item) }}" class="gs-operations-feed-item">
                                    <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->itemTone($item) }}">
                                        @if ($panel['type'] === 'service')
                                            <x-heroicon-o-wrench-screwdriver aria-hidden="true" />
                                        @else
                                            <x-heroicon-o-map-pin aria-hidden="true" />
                                        @endif
                                    </span>

                                    <span class="gs-operations-feed-item__body">
                                        <span class="gs-operations-feed-item__title">{{ $this->itemTitle($item) }}</span>
                                        <span class="gs-operations-feed-item__meta">
                                            {{ $this->itemMeta($item) }}
                                            <span>{{ $this->itemUpdatedAt($item) }}</span>
                                        </span>
                                    </span>

                                    <span class="gs-operations-status gs-operations-tone-{{ $this->itemTone($item) }}">
                                        {{ $this->itemStatusLabel($item) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="gs-operations-empty">
                            <x-heroicon-o-inbox aria-hidden="true" />
                            <span>{{ $panel['empty'] }}</span>
                        </div>
                    @endif
                </section>
            @empty
                <section class="gs-operations-panel gs-operations-panel--feed">
                    <div class="gs-operations-empty">
                        <x-heroicon-o-lock-closed aria-hidden="true" />
                        <span>{{ __('admin_agencies_services.feed_empty') }}</span>
                    </div>
                </section>
            @endforelse
        </div>

        <section class="gs-operations-panel gs-operations-panel--feed">
            <div class="gs-operations-panel__header">
                <span class="gs-operations-panel__icon" aria-hidden="true">
                    <x-heroicon-o-exclamation-triangle />
                </span>
                <div>
                    <h3>{{ __('admin_agencies_services.attention.heading') }}</h3>
                    <p>{{ __('admin_agencies_services.attention.description') }}</p>
                </div>
            </div>

            @if ($attentionItems !== [])
                <div class="gs-operations-feed">
                    @foreach ($attentionItems as $item)
                        <a href="{{ $item['href'] }}" class="gs-operations-feed-item">
                            <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $item['tone'] }}">
                                @switch($item['icon'])
                                    @case('pause')
                                        <x-heroicon-o-pause-circle aria-hidden="true" />
                                        @break

                                    @case('photo')
                                        <x-heroicon-o-photo aria-hidden="true" />
                                        @break

                                    @default
                                        <x-heroicon-o-eye-slash aria-hidden="true" />
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
                    <span>{{ __('admin_agencies_services.attention.empty') }}</span>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
