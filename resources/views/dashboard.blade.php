@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('dashboard'))
@section('content.dashboard')
@endsection
