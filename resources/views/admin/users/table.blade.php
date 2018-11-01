<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.table.name')</th>
            <th>@lang('admin.users.table.email')</th>
            <th>@lang('admin.users.table.role')</th>
            <th>@lang('admin.users.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            @if ($user->id !== Auth::id())
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roleName() }}</td>
                    <td>
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("admin/users/$user->id") }}"
                        >
                            <i class="fas fa-search mr-1"></i>
                            @lang('admin.users.table.view')
                        </a>

                        @can('update', $user)
                            <a
                                class="btn btn-primary btn-sm"
                                href="{{ url("admin/users/$user->id/edit") }}"
                            >
                                <i class="fas fa-edit mr-1"></i>
                                @lang('admin.users.table.edit')
                            </a>
                        @endcan
						@if (!Session::get('original_user'))
							<a
								class="btn btn-primary btn-sm"
								href="{{ url("admin/users/switch/$user->id") }}"
							> 
								<i class="fas fa-user mr-1"></i>
								@lang('user.form-settings.switch-user')
							</a>
						@endif
							<a
								class="btn btn-danger btn-sm"
								href="{{ url("admin/users/activate/$user->id") }}"
							> 
								<i class="fas fa-trash mr-1"></i>
								@lang('user.form-settings.inactive')
							</a>
						@if (Auth::user()->isSuperadmin())
                        @can('delete', $user)
                            {!!
                                Form::open([
                                    'class' => 'd-inline-block',
                                    'method' => 'delete',
                                    'onsubmit' => 'return confirm(\'' . __('admin.users.form-delete.on-submit') . '\')',
                                    'url' => url("admin/users/$user->id"),
                                ])
                            !!}
                            @include('admin.users.form-delete')
                            {!! Form::close() !!}
                        @endcan
						@endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
