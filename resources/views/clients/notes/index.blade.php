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

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url("clients/$user->id/notes/create") }}"
            >
                @lang('clients.notes.index.create')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($notes->isNotEmpty())
                        @include('clients.notes.table', [
                            'notes' => $notes,
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.notes.index.no-results')
                        </p>
                    @endif

                    {{ $notes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
