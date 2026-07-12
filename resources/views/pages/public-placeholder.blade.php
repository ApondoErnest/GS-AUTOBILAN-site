@extends('layouts.app')

@section('title', $title ?? config('app.name'))

@section('content')
    <section class="min-h-[60vh] bg-gs-wall" aria-label="{{ $title ?? config('app.name') }}"></section>
@endsection
