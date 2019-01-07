@extends('layout.dashboard')

@section('title', __('admin.documents.index.title'))

@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="nav-icon fas fa-file"></i>
                @lang('admin.documents.index.documents')
            </span>
		@if (Auth::user()->isAdmin())

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/documents/create') }}"
            >
                @lang('admin.documents.index.create-document')
            </a>

		@endif
        </div>

            <div class="row">
                <div class="col-12">
                    @if ($documents->isNotEmpty())
                        @include('admin.documents.table', ['documents' => $documents])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.documents.index.no-results')
                        </p>
                    @endif

                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
