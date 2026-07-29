@php
    $summaryCards = $this->summaryCards();
    $quickLinks = $this->quickLinks();
    $contentModules = $this->contentModules();
    $latestArticles = $this->latestArticles();
    $attentionItems = $this->attentionItems();
@endphp

<x-filament-panels::page>
    <div class="gs-operations gs-content" data-admin-content-page>
        <section class="gs-operations-command" aria-labelledby="gs-content-command-title">
            <div class="gs-operations-command__copy">
                <span class="gs-operations-eyebrow">{{ __('admin_content.command.eyebrow') }}</span>
                <h2 id="gs-content-command-title">{{ __('admin_content.command.heading') }}</h2>
                <p>{{ __('admin_content.command.description') }}</p>
            </div>

            <div class="gs-operations-command__actions">
                @foreach (array_slice($quickLinks, 0, 2) as $link)
                    <a href="{{ $link['href'] }}" class="gs-operations-button gs-operations-button--{{ $link['tone'] }}">
                        <span aria-hidden="true">
                            @switch($link['icon'])
                                @case('question')
                                    <x-heroicon-o-question-mark-circle />
                                    @break

                                @case('photo')
                                    <x-heroicon-o-photo />
                                    @break

                                @case('chat')
                                    <x-heroicon-o-chat-bubble-bottom-center-text />
                                    @break

                                @default
                                    <x-heroicon-o-newspaper />
                            @endswitch
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gs-operations-summary" aria-label="{{ __('admin_content.summary.label') }}">
            @foreach ($summaryCards as $card)
                <article class="gs-operations-summary-card gs-operations-tone-{{ $card['tone'] }}">
                    <span class="gs-operations-summary-card__icon" aria-hidden="true">
                        @switch($card['icon'])
                            @case('draft')
                                <x-heroicon-o-pencil-square />
                                @break

                            @case('question')
                                <x-heroicon-o-question-mark-circle />
                                @break

                            @case('photo')
                                <x-heroicon-o-photo />
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
                        <h3>{{ __('admin_content.quick_links.heading') }}</h3>
                        <p>{{ __('admin_content.quick_links.description') }}</p>
                    </div>
                </div>

                @if ($quickLinks !== [])
                    <div class="gs-operations-quick-grid">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['href'] }}" class="gs-operations-quick-card gs-operations-tone-{{ $link['tone'] }}">
                                <span class="gs-operations-quick-card__icon" aria-hidden="true">
                                    @switch($link['icon'])
                                        @case('question')
                                            <x-heroicon-o-question-mark-circle />
                                            @break

                                        @case('photo')
                                            <x-heroicon-o-photo />
                                            @break

                                        @case('chat')
                                            <x-heroicon-o-chat-bubble-bottom-center-text />
                                            @break

                                        @default
                                            <x-heroicon-o-newspaper />
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
                        <span>{{ __('admin_content.quick_links.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--workload">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-chart-bar-square />
                    </span>
                    <div>
                        <h3>{{ __('admin_content.modules.heading') }}</h3>
                        <p>{{ __('admin_content.modules.description') }}</p>
                    </div>
                </div>

                <div class="gs-operations-workload-list">
                    @foreach ($contentModules as $module)
                        <article class="gs-operations-workload-item">
                            <div class="gs-operations-workload-item__top">
                                <strong>{{ $module['label'] }}</strong>
                                <span>{{ number_format($module['count']) }}</span>
                            </div>
                            <div class="gs-operations-meter" aria-hidden="true">
                                <span style="width: {{ $module['percent'] }}%"></span>
                            </div>
                            <small>{{ $module['description'] }}</small>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="gs-operations-feed-grid">
            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-newspaper />
                    </span>
                    <div>
                        <h3>{{ __('admin_content.latest_articles.heading') }}</h3>
                        <p>{{ __('admin_content.latest_articles.description') }}</p>
                    </div>
                </div>

                @if ($latestArticles->isNotEmpty())
                    <div class="gs-operations-feed">
                        @foreach ($latestArticles as $article)
                            <a href="{{ $this->articleUrl($article) }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $this->articleTone($article->status) }}">
                                    <x-heroicon-o-document-text aria-hidden="true" />
                                </span>

                                <span class="gs-operations-feed-item__body">
                                    <span class="gs-operations-feed-item__title">{{ $this->localizedArticleTitle($article) }}</span>
                                    <span class="gs-operations-feed-item__meta">
                                        {{ $this->localizedCategoryName($article->category) ?? __('admin_content.empty_value') }}
                                        <span>{{ $article->updated_at?->format('d/m/Y H:i') ?? __('admin_content.empty_value') }}</span>
                                    </span>
                                </span>

                                <span class="gs-operations-status gs-operations-tone-{{ $this->articleTone($article->status) }}">
                                    {{ $this->articleStatusLabel($article->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="gs-operations-empty">
                        <x-heroicon-o-inbox aria-hidden="true" />
                        <span>{{ __('admin_content.latest_articles.empty') }}</span>
                    </div>
                @endif
            </section>

            <section class="gs-operations-panel gs-operations-panel--feed">
                <div class="gs-operations-panel__header">
                    <span class="gs-operations-panel__icon" aria-hidden="true">
                        <x-heroicon-o-exclamation-triangle />
                    </span>
                    <div>
                        <h3>{{ __('admin_content.attention.heading') }}</h3>
                        <p>{{ __('admin_content.attention.description') }}</p>
                    </div>
                </div>

                @if ($attentionItems !== [])
                    <div class="gs-operations-feed">
                        @foreach ($attentionItems as $item)
                            <a href="{{ $item['href'] }}" class="gs-operations-feed-item">
                                <span class="gs-operations-feed-item__marker gs-operations-tone-{{ $item['tone'] }}">
                                    @switch($item['icon'])
                                        @case('question')
                                            <x-heroicon-o-question-mark-circle aria-hidden="true" />
                                            @break

                                        @case('photo')
                                            <x-heroicon-o-photo aria-hidden="true" />
                                            @break

                                        @case('chat')
                                            <x-heroicon-o-chat-bubble-bottom-center-text aria-hidden="true" />
                                            @break

                                        @default
                                            <x-heroicon-o-pencil-square aria-hidden="true" />
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
                        <span>{{ __('admin_content.attention.empty') }}</span>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-filament-panels::page>
