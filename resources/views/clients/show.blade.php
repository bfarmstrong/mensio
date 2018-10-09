@extends('layout.dashboard')

@section('title', __('clients.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.show', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user mr-1"></i>
            @lang('clients.show.form-title')
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>

    @unless($questionnaires['assigned']->isEmpty())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-question mr-1"></i>
                @lang('clients.show.assigned-questionnaires')
            </div>

            <div class="card-body">
                @include('clients.table-questionnaires', [
                    'responses' => $questionnaires['assigned'],
                    'user' => $user,
                ])
            </div>
        </div>
    @endunless

    @can('create', \App\Models\Response::class)
        @unless($questionnaires['unassigned']->isEmpty())
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-question mr-1"></i>
                    @lang('clients.show.assign-questionnaire')
                </div>

                <div class="card-body">
                    {!!
                        Form::open([
                            'method' => 'post',
                            'url' => url("clients/$user->id/questionnaires"),
                        ])
                    !!}
                    @include('clients.form-assign-questionnaire', [
                        'questionnaires' => $questionnaires['unassigned'],
                        'user' => $user,
                    ])
                    {!! Form::close() !!}
                </div>
            </div>
        @endunless
    @endcan
@endsection
