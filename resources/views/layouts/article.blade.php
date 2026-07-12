{{-- Layout variant: article detail --}}
@extends('layouts.app')

@section('content')
    <article class="gs-layout-article bg-gs-wall">
        <header class="border-b border-gs-concrete bg-gs-surface">
            <div class="mx-auto max-w-3xl px-4 py-10">
                @hasSection('meta')
                    <div class="mb-3 text-gs-small text-gs-ink-muted">@yield('meta')</div>
                @endif
                <h1 class="text-gs-h1 font-semibold text-gs-bay">@yield('heading')</h1>
                @hasSection('lead')
                    <p class="mt-3 text-gs-lead text-gs-ink-muted">@yield('lead')</p>
                @endif
            </div>
        </header>

        @hasSection('cover')
            <div class="mx-auto max-w-4xl px-4 pt-8">@yield('cover')</div>
        @endif

        <div class="mx-auto max-w-3xl px-4 py-10 prose-gs">
            @yield('body')
        </div>

        @hasSection('related')
            <aside class="border-t border-gs-concrete bg-gs-soft">
                <div class="mx-auto max-w-6xl px-4 py-10">@yield('related')</div>
            </aside>
        @endif
    </article>
@endsection
