@extends('layout.dashboard')

@section('title', __('groups.questionnaires.create.title'))

@section(
    'content.breadcrumbs',
    Breadcrumbs::render('groups.questionnaires.create', $group)
)
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-question mr-1"></i>
            @lang('groups.questionnaires.create.assign-questionnaire')
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    {!!
                        Form::open([
                            'method' => 'post',
                            'url' => url("groups/$group->uuid/questionnaires"),
                        ])
                    !!}
                    @include('admin.groups.questionnaires.form-assign', [
                        'questionnaires' => $questionnaires,
                        'group' => $group,
                    ])
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @include('admin.groups.questionnaires.table', [
                        'responses' => $responses,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
