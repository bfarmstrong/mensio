@extends('layout.dashboard')

@section('title', __('admin.clinics.assignclinic.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.assignclinic',$clinic))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-bed mr-1"></i>
                @lang('admin.clinics.assignclinic.users')
            </span>

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url("admin/clinics/$clinic->id/assignclinic/create") }}"
            >
                @lang('admin.clinics.assignclinic.assign-users')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url("admin/clinics/$clinic->id/assignclinic/search")
                        ])
                    !!}
                    @include('admin.clinics.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($users->isNotEmpty())
                        @include('admin.clinics.assignclinics.table', ['users' => $users])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.clinics.assignclinic.no-results')
                        </p>
                    @endif

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
