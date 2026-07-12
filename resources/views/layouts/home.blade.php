{{-- Layout variant: Home — photo/navy hero, section stack, final CTA --}}
@extends('layouts.app')

@section('content')
    <div class="gs-layout-home">
        @hasSection('hero')
            <section class="gs-home-hero">
                @yield('hero')
            </section>
        @endif

        @yield('sections')

        @hasSection('final-cta')
            <section class="gs-home-final-cta border-t border-gs-concrete bg-gs-soft">
                <div class="mx-auto max-w-6xl px-4 py-12">
                    @yield('final-cta')
                </div>
            </section>
        @endif
    </div>
@endsection
