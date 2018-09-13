@extends('layout.guest')

@section('title', __('auth.passwords.forgot-password.title'))

@section('content.guest')
    <div class="card p-4">
        <div class="card-body">
            <h1>
                @lang('auth.passwords.forgot-password.form-title')
            </h1>

            <p class="text-muted">
                @lang('auth.passwords.forgot-password.form-subtitle')
            </p>

            {!!
                Form::open([
                    'url' => url('password/email'),
                ])
            !!}
            @include('auth.passwords.form-forgot-password')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
