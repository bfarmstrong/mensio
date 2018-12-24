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
		if($response->data != null){
			$answerss[]= json_decode($response->data);
		}
	@endphp
@endforeach 
@php 
$temp =array();
$temp1 =array();
foreach($en_questionnaire as $en_questionnair){
	foreach($en_questionnair as $en_quest){ 
		$temp[]=$en_quest; 
	}
} 
if(!empty($answerss)){
	foreach($answerss as $answers){ 
		foreach($answers as $key => $val){ 
			$temp1[$key]=$val; 
		}
	}
}
@endphp
@php 
	$questionnaire['pages'] = $temp; 
@endphp 
 @include('partials.multiplequestionnaire', [
        'questionnaire' => json_encode($questionnaire),
        'response' => json_encode($response1),
        'answerss' => json_encode($temp1),
    ])

@endsection
