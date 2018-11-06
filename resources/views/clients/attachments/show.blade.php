@extends('layout.dashboard')

@section('title', __('clients.attachments.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.attachments.show', $client, $attachment))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-paperclip mr-1"></i>
                @lang('clients.attachments.show.attachment')
            </span>
        </div>

        <div class="card-body">
        </div>
    </div>
@endsection
