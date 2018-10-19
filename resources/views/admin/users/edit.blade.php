@extends('layout.dashboard')

@section('title', __('admin.users.edit.title', ['role' => $user->roleName()]))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.edit', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.users.edit.form-title', ['role' => $user->roleName()])
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $user,
                    ['url' => url("admin/users/$user->id")]
                )
            !!}
            @method('patch')
            @include('user.form-settings', [
                'features' => [
                    'license' => $user->isTherapist(),
                    'switch_user' => true,
                    'therapists' => Auth::user()->can('viewTherapists', $user),
                ]
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
