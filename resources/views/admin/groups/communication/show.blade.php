@extends('layout.dashboard')

@section('title', __('clients.communication.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('groups.communication.show', $group, $communication))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-comment-alt mr-1"></i>
                @lang('clients.communication.show.communication-log')
            </span>
        </div>

        <div class="card-body">
            @include('clients.communication.form-static', [
                'communication' => $communication,
            ])
        </div>
    </div>
@endsection
