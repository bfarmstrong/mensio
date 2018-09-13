@extends('layout.dashboard')

@section('title', __('admin.roles.edit.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.roles.edit', $role))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.roles.edit.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $role,
                    ['url' => url("admin/roles/$role->id")]
                )
            !!}
            @method('patch')
            @include('admin.roles.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
