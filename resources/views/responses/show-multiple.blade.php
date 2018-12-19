@extends('layout.dashboard')

@section('title', __('responses.show-external.title'))

@section('content.dashboard')
@php 
	$en_questionnaire = array(); 
@endphp
@foreach($responses  as $response)
	@php 
		//array_push($en_questionnaire, json_decode($response->questionnaire->data)->pages);
		$en_questionnaire[] = json_decode($response->questionnaire->data)->pages;
		$response1[] = $response->uuid; 

	@endphp
@endforeach 
@php 
$temp =array();
foreach($en_questionnaire as $en_questionnair){
	foreach($en_questionnair as $en_quest){ 
		$temp[]=$en_quest; 
	}
} 
@endphp
@php $questionnaire['pages'] = $temp;  @endphp 
 @include('partials.multiplequestionnaire', [
        'questionnaire' => json_encode($questionnaire),
        'response' => json_encode($response1),
    ])

@endsection
