@extends('layout.dashboard')

@section('title', __('clients.notes.create.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.notes.create', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sticky-note mr-1"></i>
            @lang('clients.notes.create.form-title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url("clients/$user->id/notes"),
                ])
            !!}
            @include('clients.notes.form', [
                'client' => $user,
                'therapist' => Auth::user(),
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
