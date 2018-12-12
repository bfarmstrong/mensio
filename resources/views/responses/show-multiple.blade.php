@extends('layout.questionnaire')

@section('title', __('responses.show-external.title'))

@section('content.questionnaire')
    @include('partials.multiplequestionnaire', [
        'questionnaire' => $response->questionnaire,
        'response' => $response,
    ])
@endsection
