@extends('layout.app')

@section('content.main')
    <div class="container align-items-center mb-auto mt-auto">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                @yield('content.guest')
            </div>
        </div>
    </div>
@endsection
