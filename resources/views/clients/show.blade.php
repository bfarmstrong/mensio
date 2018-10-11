@extends('layout.dashboard')

@section('title', __('clients.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.show', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-user mr-1"></i>
                @lang('clients.show.form-title')
            </span>

            <div class="ml-auto">
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/questionnaires") }}"
                >
                    @lang('clients.show.questionnaires')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/notes") }}"
                >
                    @lang('clients.show.notes')
                </a>
            </div>
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>
@endsection
