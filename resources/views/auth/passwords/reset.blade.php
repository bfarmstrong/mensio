@extends('layout.guest')

@section('title', __('auth.passwords.reset-password.title'))

@section('content.guest')
    <div class="card p-4">
        <div class="card-body">
            <h1>
                @lang('auth.passwords.reset-password.form-title')
            </h1>

            <p class="text-muted">
                @lang('auth.passwords.reset-password.form-subtitle')
            </p>

            {!!
                Form::open([
                    'url' => url('password/reset'),
                ])
            !!}
            @include('auth.passwords.form-reset-password')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
