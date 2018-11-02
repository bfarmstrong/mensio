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
			@if ($user->is_active == 1)
				<a
					class="btn btn-danger btn-sm"
					href="{{ url("admin/users/inactivate/$user->id") }}"
				> 
					
					@lang('user.form-settings.inactive')
				</a>
			@else
				<a
					class="btn btn-danger btn-sm"
					href="{{ url("admin/users/activate/$user->id") }}"
				> 
								
					@lang('user.form-settings.active')
				</a>
			@endif
                <a
                    class="btn btn-primary btn-sm"
                    href="{{ url("admin/users/$user->id/edit") }}"
                >
                    @lang('admin.users.show.edit')
                </a>
            </div>
        </div>

        <div class="card-body">
            @include('admin.users.form-static', ['user' => $user])
        </div>
    </div>
@endsection
