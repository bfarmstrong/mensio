@extends('layout.app')

@section('content.main')
    @include('layout.navigation')

    <div class="app-body">
        @include('layout.sidebar')
        <main class="main">
            <div class="mb-3">
                @yield('content.breadcrumbs')
                @include('partials.errors')
                @include('partials.message')
            </div>

            <div class="container-fluid mt-3">
                @yield('content.dashboard')
            </div>
        </main>
    </div>
@endsection
