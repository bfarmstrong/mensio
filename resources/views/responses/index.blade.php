@extends('layout.dashboard')

@section('title', __('responses.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('responses.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
			<span>
				<i class="fas fa-question mr-1"></i>
				@lang('responses.index.card-title')
			</span>
			 <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url("clients/".Auth::user()->id."/surveys") }}"
			>
               @lang('clients.surveys.table.response_multiple')  
             </a>
        </div>

        <div class="card-body">
            @if ($responses->isNotEmpty())
                @include('clients.questionnaires.table', [
                    'responses' => $responses,
                    'user' => Auth::user(),
                ])
            @else
                <p class="lead text-center text-muted mt-3">
                    @lang('responses.index.no-results')
                </p>
            @endif

            {{ $responses->links() }}
        </div>
    </div>
@endsection
