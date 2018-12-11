@extends('layout.dashboard')

@section('title', __('admin.surveys.index.title'))

@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.surveys.index.surveys')
            </span>

		@if (Auth::user()->isAdmin())

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/surveys/create') }}"
            >
                @lang('admin.surveys.index.create-survey')
            </a>

		@endif

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">

				@if (Auth::user()->isAdmin())

                    {!!
                        Form::open([
                            'url' => url('admin/surveys/search')
                        ])
                    !!}

				@else
					{!!
                        Form::open([
                            'url' => url('surveys/search')
                        ])
                    !!}
				@endif

                    @include('admin.surveys.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($surveys->isNotEmpty())
                        @include('admin.surveys.table', ['surveys' => $surveys])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.surveys.index.no-results')
                        </p>
                    @endif

                    {{ $surveys->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
