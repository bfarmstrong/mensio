@extends('layout.dashboard')

@section('title', __('user.signature.title'))

@section('content.breadcrumbs', Breadcrumbs::render('user.signature'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-signature mr-1"></i>
            @lang('user.signature.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'files' => true,
                    'method' => 'patch',
                    'url' => url('user/signature'),
                ])
            !!}
            @include('user.form-signature', [
                'user' => $user,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
