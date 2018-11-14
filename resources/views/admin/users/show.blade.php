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
                    <i class="fas fa-edit mr-1"></i>
                    @lang('admin.users.show.edit')
                </a>

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/users/$user->id/groups") }}"
                    >
                        <i class="fas fa-user-plus mr-1"></i>
                        @lang('admin.users.show.groups')
                    </a>
                @endif

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("clients/$user->id/notes") }}"
                    >
                        <i class="fas fa-sticky-note mr-1"></i>
                        @lang('admin.users.show.notes')
                    </a>
                @endif

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("clients/$user->id/questionnaires") }}"
                    >
                        <i class="fas fa-question mr-1"></i>
                        @lang('admin.users.show.questionnaires')
                    </a>
                @endif

                @if (
                    isset($currentClinic) &&
                    $user->clinics->contains($currentClinic) &&
                    !Session::get('original_user')
                )
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/users/switch/$user->id") }}"
                    >
                        <i class="fas fa-redo mr-1"></i>
                        @lang('admin.users.show.switch-user')
                    </a>
                @endif

                @if ($user->isClient())
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/users/$user->id/therapists") }}"
                    >
                        <i class="fas fa-user mr-1"></i>
                        @lang('admin.users.show.therapists')
                    </a>
                @endif

                @if (
                    $user->is_active === 1 &&
                    !$user->isSuperAdmin() &&
                    $user->id !== Auth::id()
                )
                    <a
                        class="btn btn-danger btn-sm"
                        href="{{ url("admin/users/inactivate/$user->id") }}"
                    >
                        <i class="fas fa-toggle-off mr-1"></i>
                        @lang('admin.users.show.inactive')
                    </a>
                @elseif ($user->is_active === 0)
                    <a
                        class="btn btn-success btn-sm"
                        href="{{ url("admin/users/activate/$user->id") }}"
                    >
                        <i class="fas fa-toggle-on mr-1"></i>
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
