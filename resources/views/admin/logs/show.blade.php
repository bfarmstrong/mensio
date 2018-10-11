@extends('layout.dashboard')

@section('title', __('admin.logs.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.logs.show', $log))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-archive mr-1"></i>
            @lang('admin.logs.show.activity-log')
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @include('admin.logs.form-static', ['log' => $log])
                </div>
            </div>
        </div>
    </div>
@endsection
