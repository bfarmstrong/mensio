@extends('layout.dashboard')

@section('title', __('admin.clinics.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.clinics.create'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-hospital mr-1"></i>
            @lang('admin.clinics.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'files' => true,
                    'url' => url('admin/clinics')
                ])
            !!}
            @include('admin.clinics.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
