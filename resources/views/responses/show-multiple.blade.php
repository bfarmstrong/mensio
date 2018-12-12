@extends('layout.questionnaire')

@section('title', __('responses.show-external.title'))

@section('content.questionnaire')
@foreach($responses  as $response)
 @include('partials.questionnaire', [
        'questionnaire' => $response->questionnaire,
        'response' => $response,
    ])
@endforeach
@endsection
