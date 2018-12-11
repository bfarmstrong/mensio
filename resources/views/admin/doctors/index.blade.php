@extends('layout.dashboard')

@section('title', __('admin.doctors.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.doctors.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.doctors.index.doctors')
            </span>

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/doctors/create') }}"
            >
                <i class="fas fa-plus mr-1"></i>
                @lang('admin.doctors.index.create-doctor')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('admin/doctors/search')
                        ])
                    !!}
                    @include('admin.doctors.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($doctors->isNotEmpty())
                        @include('admin.doctors.table', ['doctors' => $doctors])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.doctors.index.no-results')
                        </p>
                    @endif

                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
