@extends('layout.dashboard')

@section('title', __('admin.users.show.title', ['role' => $user->roleName()]))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.show', $user))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-user mr-1"></i>
                @lang('admin.users.show.form-title', ['role' => $user->roleName()])
            </span>

            <div class="ml-auto">
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("admin/users/$user->id/edit") }}"
                >
                    @lang('admin.users.show.edit')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/notes") }}"
                >
                    @lang('admin.users.show.notes')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("clients/$user->id/questionnaires") }}"
                >
                    @lang('admin.users.show.questionnaires')
                </a>

                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("admin/users/switch/$user->id") }}"
                >
                    @lang('admin.users.show.switch-user')
                </a>

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/users/$user->id/groups") }}"
                    >
                        @lang('admin.users.show.groups')
                    </a>
                @endif

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/users/$user->id/therapists") }}"
                    >
                        @lang('admin.users.show.therapists')
                    </a>
                @endif

                @if ($user->is_active == 1)
                    <a
                        class="btn btn-danger btn-sm"
                        href="{{ url("admin/users/inactivate/$user->id") }}"
                    >
                        @lang('admin.users.show.inactive')
                    </a>
                @else
                    <a
                        class="btn btn-success btn-sm"
                        href="{{ url("admin/users/activate/$user->id") }}"
                    >
                        @lang('admin.users.show.active')
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>
@endsection
