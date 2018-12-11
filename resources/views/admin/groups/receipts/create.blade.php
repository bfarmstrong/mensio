@extends('layout.dashboard')

@section('title', __('clients.receipts.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('groups.receipts.create', $group))
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
                    'url' => url("groups/$group->uuid/receipts"),
                ])
            !!}
            @include('clients.receipts.form', [
                'disabled' => $requiresSignature,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
