@extends('layout.dashboard')

@section('title', __('clients.surveys.create.title'))

@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sticky-note mr-1"></i>
            @lang('clients.surveys.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
					'method' => 'post',
                    'url' => url("clients/$user->id/surveys/assign"),
                ])
            !!}
            @include('clients.surveys.form', [
                'client' => $user,
                'all_surveys' => $all_surveys,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
