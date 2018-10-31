@extends('layout.dashboard')

@section('title', __('clients.questionnaires.show.title'))

@section(
    'content.breadcrumbs',
    Breadcrumbs::render('clients.questionnaires.show', $user, $response)
)
@section('content.dashboard')
    <div class="card">
        <div class="card-header clearfix">
            <i class="fas fa-question mr-1"></i>
            @lang('clients.questionnaires.show.card-title')

            @isset ($score)
                <div class="float-right">
                    <strong class="text-primary">
                        @lang('clients.questionnaires.show.score', [
                            'score' => $score,
                        ])
                    </strong>
                </div>
            @endisset
        </div>

        <div class="card-body p-0">
            @include('partials.questionnaire', [
                'questionnaire' => $response->questionnaire,
            ])
        </div>
    </div>
@endsection
