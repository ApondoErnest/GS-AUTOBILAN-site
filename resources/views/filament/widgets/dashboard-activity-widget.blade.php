@php
    use App\Filament\Support\DashboardMetrics;

    $showsBothColumns = $canViewOperations && $canViewContent;
    $statusLabels = trans('admin_dashboard.statuses');
    $statusLabels = is_array($statusLabels) ? $statusLabels : [];
@endphp

<x-filament-widgets::widget class="gs-dashboard-activity-widget">
    <x-filament::section
        class="gs-dashboard-activity"
        heading="{{ __('admin_dashboard.widgets.activity.heading') }}"
        description="{{ __('admin_dashboard.widgets.activity.description') }}"
    >
        <div
            @class([
                'gs-dashboard-activity__grid',
                'gs-dashboard-activity__grid--split' => $showsBothColumns,
            ])
        >
            @if ($canViewOperations)
                <section class="gs-dashboard-activity__column" aria-labelledby="gs-dashboard-contact-title">
                    <div class="gs-dashboard-activity__column-heading">
                        <span class="gs-dashboard-activity__column-icon" aria-hidden="true">
                            <x-heroicon-o-inbox />
                        </span>

                        <h3 id="gs-dashboard-contact-title">
                            {{ __('admin_dashboard.widgets.activity.contacts_heading') }}
                        </h3>
                    </div>

                    <div class="gs-dashboard-activity__feed">
                        @forelse ($contactMessages as $message)
                            <article class="gs-dashboard-activity__item">
                                <span class="gs-dashboard-activity__item-icon" aria-hidden="true">
                                    <x-heroicon-o-envelope />
                                </span>

                                <div class="gs-dashboard-activity__item-body">
                                    <p class="gs-dashboard-activity__item-title">
                                        {{ filled($message->subject) ? $message->subject : __('admin_dashboard.widgets.activity.subject_fallback') }}
                                    </p>

                                    <p class="gs-dashboard-activity__item-meta">
                                        <span>
                                            {{ DashboardMetrics::localizedAgencyName($message->agency) ?? __('admin_dashboard.scopes.general') }}
                                        </span>

                                        @if ($message->created_at)
                                            <span>{{ $message->created_at->diffForHumans() }}</span>
                                        @endif
                                    </p>
                                </div>
                            </article>
                        @empty
                            <p class="gs-dashboard-activity__empty">
                                <x-heroicon-o-check-circle aria-hidden="true" />
                                <span>{{ __('admin_dashboard.widgets.activity.empty_contacts') }}</span>
                            </p>
                        @endforelse
                    </div>
                </section>
            @endif

            @if ($canViewContent)
                <section class="gs-dashboard-activity__column" aria-labelledby="gs-dashboard-articles-title">
                    <div class="gs-dashboard-activity__column-heading">
                        <span class="gs-dashboard-activity__column-icon" aria-hidden="true">
                            <x-heroicon-o-newspaper />
                        </span>

                        <h3 id="gs-dashboard-articles-title">
                            {{ __('admin_dashboard.widgets.activity.articles_heading') }}
                        </h3>
                    </div>

                    <div class="gs-dashboard-activity__feed">
                        @forelse ($articles as $article)
                            @php
                                $statusValue = $article->status?->value;
                                $statusLabel = filled($statusValue)
                                    ? ($statusLabels[$statusValue] ?? str($statusValue)->headline())
                                    : null;
                            @endphp

                            <article class="gs-dashboard-activity__item">
                                <span class="gs-dashboard-activity__item-icon" aria-hidden="true">
                                    <x-heroicon-o-document-text />
                                </span>

                                <div class="gs-dashboard-activity__item-body">
                                    <p class="gs-dashboard-activity__item-title">
                                        {{ DashboardMetrics::localizedArticleTitle($article) }}
                                    </p>

                                    <p class="gs-dashboard-activity__item-meta">
                                        @if ($statusLabel)
                                            <span>{{ $statusLabel }}</span>
                                        @endif

                                        @if ($article->updated_at)
                                            <span>{{ $article->updated_at->diffForHumans() }}</span>
                                        @endif
                                    </p>
                                </div>
                            </article>
                        @empty
                            <p class="gs-dashboard-activity__empty">
                                <x-heroicon-o-check-circle aria-hidden="true" />
                                <span>{{ __('admin_dashboard.widgets.activity.empty_articles') }}</span>
                            </p>
                        @endforelse
                    </div>
                </section>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
