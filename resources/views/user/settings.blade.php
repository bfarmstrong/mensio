@extends('layout.dashboard')

@section('title', __('user.settings.title'))

@section('content.breadcrumbs', Breadcrumbs::render('user.settings'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('user.settings.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $user,
                    ['url' => url('user/settings')]
                )
            !!}
            @include('user.form-settings', [
                'features' => [
                    'change_password' => true,
                ]
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
