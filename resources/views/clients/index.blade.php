@extends('layout.dashboard')

@section('title', __('clients.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('clients.index.clients')
            </span>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('clients/search')
                        ])
                    !!}
                    @include('clients.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($clients->isNotEmpty())
                        @include('clients.table', [
                            'users' => $clients
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.index.no-results')
                        </p>
                    @endif

                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
