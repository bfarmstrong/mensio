@extends('layout.dashboard')

@section('title', __('groups.notes.create.title'))
@section('content.breadcrumbs', Breadcrumbs::render('groups.notes.create', $group))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sticky-note mr-1"></i>
            @lang('groups.notes.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url("groups/$group->uuid/notes"),
                ])
            !!}
            @include('admin.groups.notes.form', [
                'group' => $group,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
