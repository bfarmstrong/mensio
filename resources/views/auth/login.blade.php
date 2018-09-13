@extends('layout.guest')

@section('title', __('auth.login.title'))

@section('content.guest')
    <div class="card p-4">
        <div class="card-body">
            <h1>
                @lang('auth.login.form-title')
            </h1>

            <p class="text-muted">
                @lang('auth.login.form-subtitle')
            </p>

            {!!
                Form::open([
                    'url' => url('login'),
                ])
            !!}
            @include('auth.form-login')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
