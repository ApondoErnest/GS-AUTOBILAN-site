{{-- Layout variant: standard content (About, Visite Technique, etc.) --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-content bg-gs-wall">
        <header class="border-b border-gs-concrete bg-gs-soft">
            <div class="mx-auto max-w-3xl px-4 py-10">
                <h1 class="text-gs-h1 font-semibold text-gs-bay">@yield('heading')</h1>
                @hasSection('lead')
                    <p class="mt-3 text-gs-lead text-gs-ink-muted">@yield('lead')</p>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-3xl px-4 py-10">
            @yield('body')
        </div>
    </div>
@endsection
