@extends('layout.guest')

@section('title', __('errors.503.title'))

@section('content.guest')
    <div class="clearfix">
        <h1 class="float-left display-3 mr-4">
            @lang('errors.503.headline')
        </h1>

        <h4 class="pt-3">
            @lang('errors.503.subheadline')
        </h4>

        <p class="text-muted">
            @lang('errors.503.contents')
        </p>
    </div>
@endsection
