@extends('layout.guest')

@section('title', __('errors.403.title'))

@section('content.guest')
    <div class="clearfix">
        <h1 class="float-left display-3 mr-4">
            @lang('errors.403.headline')
        </h1>

        <h4 class="pt-3">
            @lang('errors.403.subheadline')
        </h4>

        <p class="text-muted">
            @lang('errors.403.contents')
        </p>

        <a
            class="btn btn-primary"
            href="{{ url('/') }}"
        >
            @lang('errors.403.return-home')
        </a>
    </div>
@endsection
