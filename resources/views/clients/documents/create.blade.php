@extends('layout.dashboard')

@section('title', __('admin.documents.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.documents.create', $client))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-paperclip mr-1"></i>
                @lang('admin.documents.create.create-attachment')
            </span>
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'files' => true,
                    'url' => url("clients/documents/postcreate/$client->id"),
                ])
            !!}
            @include('clients.documents.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
