@extends('layout.dashboard')

@section('title', __('admin.groups.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.groups.create'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.groups.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/groups')
                ])
            !!}
            @include('admin.groups.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
