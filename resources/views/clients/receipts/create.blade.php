@extends('layout.dashboard')

@section('title', __('clients.receipts.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.receipts.create', $client))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-receipt mr-1"></i>
                @lang('clients.receipts.create.create-receipt')
            </span>
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'files' => true,
                    'url' => url("clients/$client->id/receipts"),
                ])
            !!}
            @include('clients.receipts.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
