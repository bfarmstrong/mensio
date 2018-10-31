@extends('layout.dashboard')

@section('title', __('clients.questionnaires.index.title'))

@section(
    'content.breadcrumbs',
    Breadcrumbs::render('clients.questionnaires.index', $user)
)
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('clients.questionnaires.index.card-title')
            </span>

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url("clients/$user->id/questionnaires/create") }}"
            >
                @lang('clients.questionnaires.index.assign')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($responses->isNotEmpty())
                        @include('clients.questionnaires.table', [
                            'responses' => $responses,
                            'user' => $user,
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.questionnaires.index.no-results')
                        </p>
                    @endif

                    {{ $responses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
