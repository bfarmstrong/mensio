@extends('layout.dashboard')

@section('title', __('admin.doctors.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.doctors.create'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-md mr-1"></i>
            @lang('admin.doctors.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/doctors')
                ])
            !!}
            @include('admin.doctors.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
