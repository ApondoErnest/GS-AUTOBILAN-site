{{-- Layout variant: listing (Agencies, Services, News, Tariffs grid) --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-listing bg-gs-wall">
        <header class="border-b border-gs-concrete bg-gs-surface">
            <div class="mx-auto max-w-6xl px-4 py-10">
                <h1 class="text-gs-h1 font-semibold text-gs-bay">@yield('heading')</h1>
                @hasSection('lead')
                    <p class="mt-3 max-w-2xl text-gs-lead text-gs-ink-muted">@yield('lead')</p>
                @endif
                @hasSection('filters')
                    <div class="mt-6">@yield('filters')</div>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-6xl px-4 py-10">
            @yield('listing')
        </div>
    </div>
@endsection
