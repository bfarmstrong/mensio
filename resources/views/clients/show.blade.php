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
                    href="{{ url("clients/$user->id/notes") }}"
                >
                    <i class="fas fa-sticky-note mr-1"></i>
                    @lang('clients.show.notes')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/questionnaires") }}"
                >
                    <i class="fas fa-question mr-1"></i>
                    @lang('clients.show.questionnaires')
                </a>
            </div>
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>
@endsection
