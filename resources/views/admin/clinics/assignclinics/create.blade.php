@extends('layout.dashboard')

@section('title', __('admin.clinics.assignclinic.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.assignclinic.assignuser', $clinic))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.clinics.assignclinic.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url("admin/clinics/$clinic->id/assignclinic"),
                ])
            !!}
            @include('admin.clinics.assignclinics.form', [
                'client' => $clinic,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection