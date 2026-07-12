{{-- Smoke page for layout variants (S030) — not a public route yet --}}
@extends('layouts.home')

@section('title', 'GS AUTOBILAN — Layout check')

@section('hero')
    {{-- Navy hero + red/white band (GS Royal Safety Bands) — photo overlay later --}}
    <div class="relative bg-gs-navy text-white">
        <div class="h-1.5 bg-gs-accent" aria-hidden="true"></div>
        <div class="h-px bg-white/80" aria-hidden="true"></div>
        <div class="bg-gradient-to-b from-gs-navy to-gs-bay px-4 py-16">
            <div class="mx-auto max-w-6xl">
                <p class="text-gs-small uppercase tracking-wider text-white/80">Layout variant</p>
                <h1 class="mt-2 text-gs-display font-semibold">Home</h1>
                <p class="mt-3 max-w-xl text-gs-lead text-white/90">Hero · sections · final CTA</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="inline-flex rounded-md bg-gs-primary px-4 py-2 text-gs-small font-medium text-white">CTA royal blue</span>
                    <span class="inline-flex rounded-md border border-white/80 bg-transparent px-4 py-2 text-gs-small font-medium text-white">CTA outline</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sections')
    <section class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-6 h-0.5 w-16 bg-gs-accent" aria-hidden="true"></div>
        <h2 class="text-gs-h2 font-semibold text-gs-bay">Section stack</h2>
        <p class="mt-2 text-gs-body text-gs-ink-muted">Placeholder for home modules.</p>
    </section>
@endsection

@section('final-cta')
    <h2 class="text-gs-h2 font-semibold text-gs-bay">Final CTA</h2>
    <p class="mt-2 text-gs-body text-gs-ink-muted">Book or track — wired later.</p>
@endsection
