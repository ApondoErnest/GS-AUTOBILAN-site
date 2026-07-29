@extends('layouts.app')

@section('title', __('news.meta_title'))

@php
    $routeLocale = app()->getLocale() === 'en' ? 'en' : 'fr';
    $hero = __('news.hero');
    $filters = __('news.filters');
    $listing = __('news.listing');
    $defaultImage = 'images/homepage/prepare-visit.png';
@endphp

@section('content')
    <section class="bg-gs-navy px-3 py-8 text-white sm:px-8 sm:py-12 lg:px-16 xl:px-24" data-news-hero>
        <div class="mx-auto max-w-[92rem]">
            <p class="inline-flex rounded-md bg-gs-accent px-3 py-1 text-xs font-black uppercase tracking-normal text-white">
                {{ $hero['eyebrow'] }}
            </p>
            <h1 class="mt-4 max-w-4xl text-2xl font-black leading-tight tracking-normal sm:text-4xl lg:text-5xl">
                {{ $hero['title'] }}
            </h1>
            <p class="mt-4 max-w-3xl text-sm font-semibold leading-relaxed text-white/85 sm:text-lg">
                {{ $hero['lead'] }}
            </p>
        </div>
    </section>

    <section class="bg-white px-3 py-6 sm:px-8 sm:py-9 lg:px-16 xl:px-24" aria-labelledby="news-listing-title" data-news-index>
        <div class="mx-auto max-w-[92rem]">
            <div class="flex flex-col gap-4 border-b border-gs-concrete pb-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-normal text-gs-primary">{{ $filters['label'] }}</p>
                    <h2 id="news-listing-title" class="mt-1 text-xl font-black leading-tight text-gs-navy sm:text-3xl">
                        {{ $listing['title'] }}
                    </h2>
                </div>

                <nav class="flex flex-wrap gap-2" aria-label="{{ $filters['label'] }}">
                    <a href="{{ route($routeLocale.'.news', [], false) }}" @class([
                        'inline-flex min-h-10 items-center rounded-md border px-3 text-sm font-black transition focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2',
                        'border-gs-primary bg-gs-primary text-white' => $selectedCategory === null,
                        'border-gs-concrete bg-white text-gs-navy hover:bg-gs-soft' => $selectedCategory !== null,
                    ])>
                        {{ $filters['all'] }}
                    </a>

                    @foreach ($categories as $category)
                        @php
                            $categorySlug = $content->localized($category, 'slug', $routeLocale);
                            $categoryName = $content->localized($category, 'name', $routeLocale);
                            $isActive = $selectedCategory?->is($category) ?? false;
                        @endphp

                        @if ($categorySlug && $categoryName)
                            <a href="{{ route($routeLocale.'.news', [], false).'?'.http_build_query(['category' => $categorySlug]) }}" @class([
                                'inline-flex min-h-10 items-center rounded-md border px-3 text-sm font-black transition focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2',
                                'border-gs-primary bg-gs-primary text-white' => $isActive,
                                'border-gs-concrete bg-white text-gs-navy hover:bg-gs-soft' => ! $isActive,
                            ])>
                                {{ $categoryName }}
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>

            @if ($articles->isEmpty())
                <div class="mt-6 rounded-lg border border-dashed border-gs-concrete bg-gs-soft px-5 py-8 text-center" data-news-empty>
                    <h3 class="text-xl font-black text-gs-navy">{{ $listing['empty_title'] }}</h3>
                    <p class="mx-auto mt-2 max-w-xl text-sm font-semibold leading-relaxed text-gs-ink-muted">{{ $listing['empty_body'] }}</p>
                </div>
            @else
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-news-article-grid>
                    @foreach ($articles as $article)
                        @php
                            $articleTitle = $content->localized($article, 'title', $routeLocale);
                            $articleSummary = $content->localized($article, 'summary', $routeLocale);
                            $articleSlug = $content->localized($article, 'slug', $routeLocale);
                            $categoryName = $article->category ? $content->localized($article->category, 'name', $routeLocale) : null;
                            $image = $content->publicImageUrl($article->featured_image, $defaultImage);
                            $date = $article->published_at?->format('d/m/Y');
                        @endphp

                        @if ($articleTitle && $articleSlug)
                            <article class="group overflow-hidden rounded-lg border border-gs-concrete bg-white shadow-md shadow-gs-navy/8 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-gs-navy/12" data-news-card>
                                <a href="{{ route($routeLocale.'.article.show', ['slug' => $articleSlug], false) }}" class="block aspect-[16/9] overflow-hidden bg-gs-soft">
                                    <x-media.picture :src="$image" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                                </a>

                                <div class="p-5">
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-bold uppercase text-gs-ink-muted">
                                        @if ($categoryName)
                                            <span class="text-gs-primary">{{ $categoryName }}</span>
                                        @endif
                                        @if ($date)
                                            <span>{{ $listing['published'] }} {{ $date }}</span>
                                        @endif
                                    </div>

                                    <h3 class="mt-3 text-lg font-black leading-tight text-gs-navy">
                                        <a href="{{ route($routeLocale.'.article.show', ['slug' => $articleSlug], false) }}" class="transition hover:text-gs-primary focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                            {{ $articleTitle }}
                                        </a>
                                    </h3>

                                    @if ($articleSummary)
                                        <p class="mt-3 text-sm font-semibold leading-relaxed text-gs-ink-muted">{{ $articleSummary }}</p>
                                    @endif

                                    <a href="{{ route($routeLocale.'.article.show', ['slug' => $articleSlug], false) }}" class="mt-5 inline-flex min-h-10 items-center gap-2 text-sm font-black text-gs-primary transition hover:text-gs-navy focus:outline-none focus:ring-2 focus:ring-gs-primary focus:ring-offset-2">
                                        <span>{{ $listing['read'] }}</span>
                                        <x-heroicon-o-chevron-right class="h-4 w-4" aria-hidden="true" />
                                    </a>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
