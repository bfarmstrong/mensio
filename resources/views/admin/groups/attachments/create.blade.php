@extends('layout.dashboard')

@section('title', __('clients.attachments.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('groups.attachments.create', $group))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-paperclip mr-1"></i>
                @lang('clients.attachments.create.create-attachment')
            </span>
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'files' => true,
                    'url' => url("groups/$group->uuid/attachments"),
                ])
            !!}
            @include('clients.attachments.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
