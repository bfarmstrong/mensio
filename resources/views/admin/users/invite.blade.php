@extends('layout.dashboard')

@section('title', __('admin.users.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.invite'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.users.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/users/invite')
                ])
            !!}
            @include('user.form-settings', [
                'features' => [
                    'license' => true,
                ],
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
