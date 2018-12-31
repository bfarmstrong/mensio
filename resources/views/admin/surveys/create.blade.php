@extends('layout.dashboard')

@section('title', __('admin.surveys.create.title'))


@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.surveys.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/surveys')
                ])
            !!}
			{!! Form::hidden('user_id', Auth::user()->id) !!}
            @include('admin.surveys.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
