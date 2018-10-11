@extends('layout.dashboard')

@section('title', __('clients.questionnaires.create.title'))

@section(
    'content.breadcrumbs',
    Breadcrumbs::render('clients.questionnaires.create', $user)
)
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-question mr-1"></i>
            @lang('clients.questionnaires.create.assign-questionnaire')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'method' => 'post',
                    'url' => url("clients/$user->id/questionnaires"),
                ])
            !!}
            @include('clients.questionnaires.form-assign', [
                'questionnaires' => $questionnaires,
                'user' => $user,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
