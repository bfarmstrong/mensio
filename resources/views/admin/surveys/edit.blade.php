@extends('layout.dashboard')

@section('title', __('admin.surveys.edit.title'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.surveys.edit.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::model(
                    $survey,
                    ['url' => url("admin/surveys/$survey->id")]
                )
            !!}
            @method('patch')
            @include('admin.surveys.form', [
                'survey' => $survey,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
