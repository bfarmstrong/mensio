@extends('layout.dashboard')

@section('title', __('admin.groups.edit.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.groups.edit', $group))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.groups.edit.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $group,
                    ['url' => url("admin/groups/$group->uuid")]
                )
            !!}
            @method('patch')
            @include('admin.groups.form', [
                'group' => $group,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
