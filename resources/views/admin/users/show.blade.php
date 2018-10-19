@extends('layout.dashboard')

@section('title', __('admin.users.show.title', ['role' => $user->roleName()]))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.show', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user mr-1"></i>
            @lang('admin.users.show.form-title', ['role' => $user->roleName()])
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>
@endsection