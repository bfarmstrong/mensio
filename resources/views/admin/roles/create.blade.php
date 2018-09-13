@extends('layout.dashboard')

@section('title', __('admin.roles.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.roles.create'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-lock mr-1"></i>
            @lang('admin.roles.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/roles')
                ])
            !!}
            @include('admin.roles.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
