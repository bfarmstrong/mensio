@extends('layout.dashboard')

@section('title', __('clients.communication.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.communication.create', $client))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-comment-alt mr-1"></i>
                @lang('clients.communication.create.create-communication-log')
            </span>
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url("clients/$client->id/communication"),
                ])
            !!}
            @include('clients.communication.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
