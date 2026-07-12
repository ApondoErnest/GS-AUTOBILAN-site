{{-- Layout variant: tracking lookup + result --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-tracking bg-gs-wall">
        <header class="border-b border-gs-concrete bg-gs-surface">
            <div class="mx-auto max-w-xl px-4 py-10">
                <h1 class="text-gs-h1 font-semibold text-gs-bay">@yield('heading')</h1>
                @hasSection('lead')
                    <p class="mt-3 text-gs-lead text-gs-ink-muted">@yield('lead')</p>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-xl space-y-8 px-4 py-10">
            <section class="rounded-md border border-gs-concrete bg-gs-surface p-6">
                @yield('lookup')
            </section>

            @hasSection('result')
                <section class="rounded-md border border-gs-concrete bg-gs-surface p-6">
                    @yield('result')
                </section>
            @endif

            @hasSection('error')
                <section class="rounded-md border border-gs-danger/30 bg-gs-surface p-6 text-gs-danger" role="alert">
                    @yield('error')
                </section>
            @endif
        </div>
    </div>
@endsection
