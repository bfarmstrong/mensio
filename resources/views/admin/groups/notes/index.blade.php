@extends('layout.dashboard')

@section('title', __('groups.notes.index.title'))
@section('content.breadcrumbs', Breadcrumbs::render('groups.notes.index', $group))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('groups.notes.index.notes')
            </span>

            <div class="ml-auto">
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("groups/$group->uuid/notes/create") }}"
                >
                    @lang('groups.notes.index.create')
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($notes->isNotEmpty())
                        @include('admin.groups.notes.table', [
                            'notes' => $notes,
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('groups.notes.index.no-results')
                        </p>
                    @endif

                    {{ $notes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
