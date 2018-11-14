@extends('layout.dashboard')

@section('title', __('admin.clinics.edit.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.edit', $clinic))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.clinics.edit.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $clinic,
                    [
                        'files' => true,
                        'url' => url("admin/clinics/$clinic->uuid"),
                    ]
                )
            !!}
            @method('patch')
            @include('admin.clinics.form', [
                'clinic' => $clinic,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
