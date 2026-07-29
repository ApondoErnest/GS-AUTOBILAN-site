@extends('layouts.app')

@section('title', $title ?? __('news.article_meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $detail = __('news.detail');
    $articleTitle = $content->localized($article, 'title', $routeLocale) ?? __('news.article_meta_title');
    $articleSummary = $content->localized($article, 'summary', $routeLocale);
    $articleBody = $content->localized($article, 'content', $routeLocale) ?? '';
    $articleParagraphs = collect(preg_split('/\R{2,}/', trim($articleBody)) ?: [])
        ->map(fn (string $paragraph): string => trim($paragraph))
        ->filter();
    $categoryName = $article->category ? $content->localized($article->category, 'name', $routeLocale) : null;
    $publishedDate = $article->published_at?->format('d/m/Y');
@endphp

@section('content')
    <article class="bg-white" data-news-article>
        <header class="bg-gs-navy px-3 py-8 text-white sm:px-8 sm:py-12 lg:px-16 xl:px-24">
            <div class="mx-auto max-w-4xl">
                <a href="{{ route($routeLocale.'.news', [], false) }}" class="inline-flex min-h-10 items-center gap-2 rounded-md border border-white/30 px-3 text-sm font-black text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gs-navy">
                    <x-heroicon-o-arrow-left class="h-4 w-4" aria-hidden="true" />
                    <span>{{ $detail['back'] }}</span>
                </a>

                <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs font-black uppercase tracking-normal text-white/80">
                    @if ($categoryName)
                        <span class="rounded-md bg-gs-accent px-2.5 py-1 text-white">{{ $categoryName }}</span>
                    @endif
                    @if ($publishedDate)
                        <span>{{ $detail['published'] }} {{ $publishedDate }}</span>
                    @endif
                </div>

                <h1 class="mt-4 text-2xl font-black leading-tight tracking-normal sm:text-4xl lg:text-5xl">
                    {{ $articleTitle }}
                </h1>

                @if ($articleSummary)
                    <p class="mt-4 text-sm font-semibold leading-relaxed text-white/85 sm:text-lg">
                        {{ $articleSummary }}
                    </p>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-5xl px-3 py-6 sm:px-8 sm:py-9 lg:px-16">
            <div class="overflow-hidden rounded-lg border border-gs-concrete bg-gs-soft shadow-md shadow-gs-navy/8">
                <x-media.picture :src="$featuredImage" alt="" loading="eager" fetchpriority="high" class="aspect-[16/9] w-full object-cover" />
            </div>

            <div class="mx-auto mt-7 max-w-3xl space-y-5 text-base font-semibold leading-relaxed text-gs-ink-muted sm:text-lg" data-news-article-body>
                @forelse ($articleParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @empty
                    <p>{{ $articleSummary }}</p>
                @endforelse
            </div>

            <section class="mx-auto mt-9 max-w-3xl rounded-lg border border-gs-primary/20 bg-gs-soft p-5 sm:p-6" data-news-article-cta>
                <h2 class="text-xl font-black text-gs-navy">{{ $detail['cta_title'] }}</h2>
                <p class="mt-2 text-sm font-semibold leading-relaxed text-gs-ink-muted sm:text-base">{{ $detail['cta_body'] }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route($routeLocale.'.booking', [], false) }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-gs-primary px-4 text-sm font-black text-white shadow-lg shadow-gs-primary/20 transition hover:bg-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                        <x-heroicon-o-calendar-days class="h-5 w-5" aria-hidden="true" />
                        <span>{{ $detail['booking'] }}</span>
                    </a>
                    <a href="{{ route($routeLocale.'.contact', [], false) }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-gs-primary bg-white px-4 text-sm font-black text-gs-primary transition hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                        <x-heroicon-o-chat-bubble-left-right class="h-5 w-5" aria-hidden="true" />
                        <span>{{ $detail['contact'] }}</span>
                    </a>
                </div>
            </section>
        </div>

        <aside class="border-t border-gs-concrete bg-gs-wall px-3 py-8 sm:px-8 lg:px-16 xl:px-24" data-news-related>
            <div class="mx-auto max-w-[92rem]">
                <h2 class="text-2xl font-black text-gs-navy">{{ $detail['related_title'] }}</h2>

                @if ($relatedArticles->isEmpty())
                    <p class="mt-3 text-sm font-semibold text-gs-ink-muted">{{ $detail['related_empty'] }}</p>
                @else
                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedArticles as $relatedArticle)
                            @php
                                $relatedTitle = $content->localized($relatedArticle, 'title', $routeLocale);
                                $relatedSummary = $content->localized($relatedArticle, 'summary', $routeLocale);
                                $relatedSlug = $content->localized($relatedArticle, 'slug', $routeLocale);
                                $relatedCategory = $relatedArticle->category ? $content->localized($relatedArticle->category, 'name', $routeLocale) : null;
                                $relatedImage = $content->publicImageUrl($relatedArticle->featured_image, 'images/homepage/necessary-docs.png');
                            @endphp

                            @if ($relatedTitle && $relatedSlug)
                                <x-cards.article
                                    :title="$relatedTitle"
                                    :excerpt="$relatedSummary"
                                    :href="route($routeLocale.'.article.show', ['slug' => $relatedSlug], false)"
                                    :category="$relatedCategory"
                                    :date="$relatedArticle->published_at?->format('d/m/Y')"
                                    :image="$relatedImage"
                                />
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </article>
@endsection
