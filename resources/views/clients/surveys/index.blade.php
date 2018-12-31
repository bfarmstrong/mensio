@extends('layout.dashboard')

@section('title', __('clients.surveys.index.title'))

@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-poll mr-1"></i>
                @lang('clients.surveys.index.card-title')
            </span>
			@if (!Auth::user()->isClient())
			<a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url("clients/$client->id/surveys/assign") }}"
			>
                 @lang('clients.surveys.table.create') 
             </a>
			@endif
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($surveys->isNotEmpty())
                        @include('clients.surveys.table', [
                            'surveys' => $surveys,
                            'client' => $client,
                        ])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('clients.surveys.index.no-results')
                        </p>
                    @endif

                    {{ $surveys->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
