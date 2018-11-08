@extends('layout.dashboard')

@section('title', __('clients.notes.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.notes.index', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('clients.notes.index.notes')
            </span>

            <div class="ml-auto">
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/attachments/create") }}"
                >
                    @lang('clients.notes.index.create-attachment')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/notes/create") }}"
                >
                    @lang('clients.notes.index.create')
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($attachments->isNotEmpty() || $notes->isNotEmpty())
                        @include('clients.notes.table', [
                            'attachments' => $attachments,
                            'notes' => $notes,
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.notes.index.no-results')
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
