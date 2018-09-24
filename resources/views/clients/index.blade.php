@extends('layout.dashboard')

@section('title', __('clients.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <i class="fas fa-list-ul mr-1"></i>
            @lang('clients.index.clients')
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($clients->isNotEmpty())
                        @include('admin.users.table', [
                            'base' => 'clients',
                            'users' => $clients
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.index.no-results')
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
