@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.dashboard'))
@section('content.dashboard')
@endsection
