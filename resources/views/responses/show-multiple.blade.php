@extends('layout.questionnaire')

@section('title', __('responses.show-external.title'))

@section('content.questionnaire')
@foreach($responses  as $response)
 @include('partials.multiplequestionnaire', [
        'questionnaire' => $response,
        'response' => $response,
    ])
@endforeach
@endsection
