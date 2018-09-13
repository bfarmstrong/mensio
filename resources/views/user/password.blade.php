@extends('layout.dashboard')

@section('title', __('user.password.title'))

@section('content.breadcrumbs', Breadcrumbs::render('user.password'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-asterisk mr-1"></i>
            @lang('user.password.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('user/password'),
                ])
            !!}
            @include('user.form-password')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
