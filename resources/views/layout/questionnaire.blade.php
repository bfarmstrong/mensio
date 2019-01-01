@extends('layout.app')

@section('content.main')
    <div class="container align-items-center mb-auto mt-auto">
        <div class="row mb-3">
            <div class="col-12">
                @include('partials.errors')
                @include('partials.message')
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                @yield('content.questionnaire')
            </div>
        </div>
    </div>
@endsection
