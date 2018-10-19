@extends('layout.dashboard')

@section('title', __('admin.doctors.edit.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.doctors.edit', $doctor))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.doctors.edit.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $doctor,
                    ['url' => url("admin/doctors/$doctor->uuid")]
                )
            !!}
            @method('patch')
            @include('admin.doctors.form', [
                'doctor' => $doctor,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
