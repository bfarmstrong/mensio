@extends('layout.dashboard')

@section('title', __('admin.clinics.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-hospital mr-1"></i>
                @lang('admin.clinics.index.clinics')
            </span>
			@if (Auth::user()->isSuperAdmin())
            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/clinics/create') }}"
            >
                @lang('admin.clinics.index.create-clinic')
            </a>
			@endif
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('admin/clinics/search')
                        ])
                    !!}
                    @include('admin.clinics.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($clinics->isNotEmpty())
                        @include('admin.clinics.table', ['clinics' => $clinics])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.clinics.index.no-results')
                        </p>
                    @endif

                    {{ $clinics->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
