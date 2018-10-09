@extends('layout.dashboard')

@section('title', __('responses.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('responses.show', $response))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-question mr-1"></i>
            @lang('responses.show.card-title')
        </div>

        <div class="card-body p-0">
            @include('partials.questionnaire', [
                'questionnaire' => $response->questionnaire,
                'response' => $response,
            ])
        </div>
    </div>
@endsection
