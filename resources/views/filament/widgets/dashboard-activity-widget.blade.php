@php
    $showsBothColumns = $canViewOperations && $canViewContent;
@endphp

<x-filament-widgets::widget>
    <x-filament::section
        heading="Latest activity"
        description="Recent contact and content signals for the current staff scope."
    >
        <div
            @class([
                'grid gap-6',
                'md:grid-cols-2' => $showsBothColumns,
            ])
        >
            @if ($canViewOperations)
                <section class="space-y-3">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">
                        Latest contact messages
                    </h3>

                    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 bg-white dark:divide-white/10 dark:border-white/10 dark:bg-white/5">
                        @forelse ($contactMessages as $message)
                            <div class="space-y-1 px-4 py-3">
                                <p class="truncate text-sm font-medium text-gray-950 dark:text-white">
                                    {{ $message->subject }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->agency?->name_fr ?? 'General' }} · {{ $message->created_at?->diffForHumans() }}
                                </p>
                            </div>
                        @empty
                            <p class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                No contact messages yet.
                            </p>
                        @endforelse
                    </div>
                </section>
            @endif

            @if ($canViewContent)
                <section class="space-y-3">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">
                        Latest articles
                    </h3>

                    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-200 bg-white dark:divide-white/10 dark:border-white/10 dark:bg-white/5">
                        @forelse ($articles as $article)
                            <div class="space-y-1 px-4 py-3">
                                <p class="truncate text-sm font-medium text-gray-950 dark:text-white">
                                    {{ $article->title_fr }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ str($article->status->value)->headline() }} · {{ $article->updated_at?->diffForHumans() }}
                                </p>
                            </div>
                        @empty
                            <p class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                No articles yet.
                            </p>
                        @endforelse
                    </div>
                </section>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
