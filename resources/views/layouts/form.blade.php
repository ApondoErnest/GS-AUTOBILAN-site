{{-- Layout variant: form pages (Booking, Contact) --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-form bg-gs-wall">
        <header class="border-b border-gs-concrete bg-gs-surface">
            <div class="mx-auto max-w-2xl px-4 py-10">
                <h1 class="text-gs-h1 font-semibold text-gs-bay">@yield('heading')</h1>
                @hasSection('lead')
                    <p class="mt-3 text-gs-lead text-gs-ink-muted">@yield('lead')</p>
                @endif
                @hasSection('notice')
                    <div class="mt-6 rounded-md border border-gs-accent/40 bg-gs-accent-soft p-4 text-gs-small text-gs-ink">
                        @yield('notice')
                    </div>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-2xl px-4 py-10">
            @yield('form')
        </div>
    </div>
@endsection
