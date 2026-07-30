@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $workloadItems = $this->workloadItems();
    $latestMessages = $this->latestMessages();
    $attentionItems = $this->attentionItems();
@endphp

<x-filament-panels::page>
    <div class="gs-operations gs-communication" data-admin-communication-page>
        <section class="gs-operations-command" aria-labelledby="gs-communication-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_communication.command.eyebrow') }}</span>
                <h2 id="gs-communication-command-title">{{ __('admin_communication.command.heading') }}</h2>
                <p>{{ __('admin_communication.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            <x-heroicon-o-inbox />
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gs-operations-summary" aria-label="{{ __('admin_communication.summary.label') }}">
            @foreach ($summaryCards as $card)
                <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                    <span class="gs-operations-summary-card__icon" aria-hidden="true">
                        @switch($card['icon'])
                            @case('envelope')
                                <x-heroicon-o-envelope />
                                @break

                            @case('clock')
                                <x-heroicon-o-clock />
                                @break

                            @case('check')
                                <x-heroicon-o-check-circle />
                                @break

                            @default
                                <x-heroicon-o-inbox />
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
                        <x-heroicon-o-chat-bubble-left-right />
                    </span>
                    <div>
                        <h3>{{ __('admin_communication.quick_links.heading') }}</h3>
                        <p>{{ __('admin_communication.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    <x-heroicon-o-inbox />
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
                        <span>{{ __('admin_communication.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-chart-bar-square />
                    </span>
                    <div>
                        <h3>{{ __('admin_communication.workload.heading') }}</h3>
                        <p>{{ __('admin_communication.workload.description') }}</p>
                    </div>
                </div>

                <div class="gs-operations-workload-list">
                    @foreach ($workloadItems as $item)
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
                        <x-heroicon-o-envelope-open />
                    </span>
                    <div>
                        <h3>{{ __('admin_communication.latest.heading') }}</h3>
                        <p>{{ __('admin_communication.latest.description') }}</p>
                    </div>
                </div>

                @if ($latestMessages->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestMessages as $message)
                            <a href="{{ $this->messageUrl($message) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->messageTone($message) }}">
                                    <x-heroicon-o-chat-bubble-left-right aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $this->messageTitle($message) }}</span>
                                    <span class="gs-operations-feed-item__meta">{{ $this->messageMeta($message) }}</span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->messageTone($message) }}">
                                    {{ $this->messageStatusLabel($message) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_communication.latest.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-exclamation-triangle />
                    </span>
                    <div>
                        <h3>{{ __('admin_communication.attention.heading') }}</h3>
                        <p>{{ __('admin_communication.attention.description') }}</p>
                    </div>
                </div>

                @if ($attentionItems !== [])
                    <div class="gs-operations-feed">
                        @foreach ($attentionItems as $item)
                            <a href="{{ $item['href'] }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $item['tone'] }}">
                                    @switch($item['icon'])
                                        @case('envelope')
                                            <x-heroicon-o-envelope aria-hidden="true" />
                                            @break

                                        @case('clock')
                                            <x-heroicon-o-clock aria-hidden="true" />
                                            @break

                                        @case('user')
                                            <x-heroicon-o-user-circle aria-hidden="true" />
                                            @break

                                        @default
                                            <x-heroicon-o-exclamation-triangle aria-hidden="true" />
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
                        <span>{{ __('admin_communication.attention.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-filament-panels::page>
