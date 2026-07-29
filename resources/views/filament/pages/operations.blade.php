@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $workload = $this->agencyWorkload();
    $latestBookings = $this->latestBookings();
    $latestDocuments = $this->latestDocuments();
@endphp

<x-filament-panels::page>
    <div class="gs-operations" data-admin-operations-page>
        <section class="gs-operations-command" aria-labelledby="gs-operations-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_operations.command.eyebrow') }}</span>
                <h2 id="gs-operations-command-title">{{ __('admin_operations.command.heading') }}</h2>
                <p>{{ __('admin_operations.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            @switch($link['icon'])
                                @case('plus')
                                    <x-heroicon-o-plus />
                                    @break

                                @case('document')
                                    <x-heroicon-o-clipboard-document-check />
                                    @break

                                @default
                                    <x-heroicon-o-calendar-days />
                            @endswitch
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gs-operations-summary" aria-label="{{ __('admin_operations.summary.label') }}">
            @foreach ($summaryCards as $card)
                <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                    <span class="gs-operations-summary-card__icon" aria-hidden="true">
                        @switch($card['icon'])
                            @case('clock')
                                <x-heroicon-o-clock />
                                @break

                            @case('document')
                                <x-heroicon-o-document-magnifying-glass />
                                @break

                            @case('check')
                                <x-heroicon-o-check-circle />
                                @break

                            @default
                                <x-heroicon-o-calendar-days />
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
                        <x-heroicon-o-bolt />
                    </span>
                    <div>
                        <h3>{{ __('admin_operations.quick_links.heading') }}</h3>
                        <p>{{ __('admin_operations.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    @switch($link['icon'])
                                        @case('plus')
                                            <x-heroicon-o-plus />
                                            @break

                                        @case('document')
                                            <x-heroicon-o-clipboard-document-check />
                                            @break

                                        @case('check')
                                            <x-heroicon-o-document-plus />
                                            @break

                                        @default
                                            <x-heroicon-o-calendar-days />
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
                        <span>{{ __('admin_operations.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-building-office-2 />
                    </span>
                    <div>
                        <h3>{{ __('admin_operations.workload.heading') }}</h3>
                        <p>{{ __('admin_operations.workload.description') }}</p>
                    </div>
                </div>

                @if ($workload->isNotEmpty())
                    <div class="gs-operations-workload-list">
                        @foreach ($workload as $agency)
                            <article class="gs-operations-workload-item">
                                <div class="gs-operations-workload-item__top">
                                    <strong>{{ $agency['label'] }}</strong>
                                    <span>{{ number_format($agency['count']) }}</span>
                                </div>
                                <div class="gs-operations-meter" aria-hidden="true">
                                    <span style="width: {{ $agency['percent'] }}%"></span>
                                </div>
                                <small>{{ __('admin_operations.workload.metric') }}</small>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_operations.workload.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>

        <div class="gs-operations-feed-grid">
            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-calendar-days />
                    </span>
                    <div>
                        <h3>{{ __('admin_operations.latest_bookings.heading') }}</h3>
                        <p>{{ __('admin_operations.latest_bookings.description') }}</p>
                    </div>
                </div>

                @if ($latestBookings->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestBookings as $booking)
                            <a href="{{ $this->bookingUrl($booking) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->bookingTone($booking->status) }}">
                                    <x-heroicon-o-calendar aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $booking->reference }} - {{ $booking->customer_name }}</span>
                                    <span class="gs-operations-feed-item__meta">
                                        {{ $this->localizedServiceTitle($booking->service) ?? __('admin_operations.empty_value') }}
                                        <span>{{ $booking->preferred_date?->format('d/m/Y') ?? __('admin_operations.empty_value') }}</span>
                                    </span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->bookingTone($booking->status) }}">
                                    {{ $this->bookingStatusLabel($booking->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_operations.latest_bookings.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-document-check />
                    </span>
                    <div>
                        <h3>{{ __('admin_operations.latest_documents.heading') }}</h3>
                        <p>{{ __('admin_operations.latest_documents.description') }}</p>
                    </div>
                </div>

                @if ($latestDocuments->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestDocuments as $document)
                            <a href="{{ $this->documentUrl($document) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->documentTone($document->status) }}">
                                    <x-heroicon-o-document-text aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">
                                        {{ $document->booking?->reference ?? __('admin_operations.empty_value') }} - {{ $document->booking?->customer_name ?? __('admin_operations.empty_value') }}
                                    </span>
                                    <span class="gs-operations-feed-item__meta">
                                        {{ $this->localizedAgencyName($document->booking?->agency) ?? __('admin_operations.empty_value') }}
                                        <span>{{ $document->updated_at?->format('d/m/Y H:i') ?? __('admin_operations.empty_value') }}</span>
                                    </span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->documentTone($document->status) }}">
                                    {{ $this->documentStatusLabel($document->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_operations.latest_documents.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-filament-panels::page>
