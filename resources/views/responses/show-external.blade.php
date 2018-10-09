@extends('layout.questionnaire')

@section('title', __('responses.show-external.title'))

@section('content.questionnaire')
    @include('partials.questionnaire', [
        'questionnaire' => $response->questionnaire,
        'response' => $response,
    ])
@endsection
