{{-- Layout variant: error pages (404 / 500) — still uses public chrome --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-error flex flex-1 items-center justify-center bg-gs-wall px-4 py-20">
        <div class="max-w-lg text-center">
            @hasSection('code')
                <p class="text-gs-display font-semibold text-gs-primary">@yield('code')</p>
            @endif
            <h1 class="mt-2 text-gs-h1 font-semibold text-gs-ink">@yield('heading')</h1>
            @hasSection('lead')
                <p class="mt-3 text-gs-lead text-gs-ink-muted">@yield('lead')</p>
            @endif
            @hasSection('actions')
                <div class="mt-8 flex flex-wrap justify-center gap-3">@yield('actions')</div>
            @endif
        </div>
    </div>
@endsection
