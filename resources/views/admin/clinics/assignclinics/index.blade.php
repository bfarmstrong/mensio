@extends('layout.dashboard')

@section('title', __('admin.clinics.assignclinic.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.assignclinic', $clinic))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-user mr-1"></i>
                @lang('admin.clinics.assignclinic.users')
            </span>

            <a
                class="btn btn-primary btn-sm ml-auto"
                @if (Auth::user()->isSuperAdmin())
                    href="{{ url("admin/clinics/$clinic->uuid/assignclinic/create") }}"
                @else
                    href="{{ url('admin/users/add') }}"
                @endif
            >
                <i class="fas fa-user-plus mr-1"></i>
                @lang('admin.clinics.assignclinic.assign-users')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($users->isNotEmpty())
                        @include('admin.clinics.assignclinics.table', ['users' => $users])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.clinics.assignclinic.no-results')
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
