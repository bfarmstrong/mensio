@extends('layout.dashboard')

@section('title', __('responses.show-external.title'))

@section('content.dashboard')
@foreach($responses  as $response)
 @include('partials.multiplequestionnaire', [
        'questionnaire' => $response,
        'response' => $response,
    ])
@endforeach
@endsection
