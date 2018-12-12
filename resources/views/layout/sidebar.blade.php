<div class="sidebar sidebar-show">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('layout.sidebar.menu')
            </li>

            @can('viewClients', \App\Models\User::class)
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ url('clients') }}"
                    >
                        <i class="nav-icon fas fa-users"></i>
                        @lang('layout.sidebar.clients')
                    </a>
                </li>
				<li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ url('groups') }}"
                    >
                        <i class="nav-icon fas fa-user-plus"></i>
                        @lang('layout.sidebar.groups')
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a
                    class="nav-link"
                    @if (Auth::user()->isAdmin())
                    href="{{ url('admin/dashboard') }}"
                    @else
                    href="{{ url('dashboard') }}"
                    @endif
                >
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('layout.sidebar.dashboard')
                </a>
            </li>

            @if (Auth::user()->isClient())
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ url('responses') }}"
                    >
                        <i class="nav-icon fas fa-question"></i>
                        @lang('layout.sidebar.questionnaires')
                    </a>
                </li>
            @endif

            @if (Auth::user()->isAdmin())
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fas fa-user-tie"></i>
                        @lang('layout.sidebar.admin')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/users') }}"
                            >
                                <i class="nav-icon fas fa-user-friends"></i>
                                @lang('layout.sidebar.users')
                            </a>
                        </li>

						<li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/groups') }}"
                            >
                                <i class="nav-icon fas fa-user-plus"></i>
                                @lang('layout.sidebar.groups')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/doctors') }}"
                            >
                                <i class="nav-icon fas fa-user-md"></i>
                                @lang('layout.sidebar.doctors')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/clinics') }}"
                            >
                                <i class="nav-icon fas fa-hospital"></i>
                                @lang('layout.sidebar.clinics')
                            </a>
                        </li>
						<li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/surveys') }}"
                            >
                                <i class="nav-icon fas fa-user-friends"></i>
                                @lang('layout.sidebar.surveys')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/roles') }}"
                            >
                                <i class="nav-icon fas fa-lock"></i>
                                @lang('layout.sidebar.roles')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/logs') }}"
                            >
                                <i class="nav-icon fas fa-archive"></i>
                                @lang('layout.sidebar.activity')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Session::get('original_user'))
                <li class="nav-item mt-auto">
                    <a
                        class="nav-link nav-link-primary bg-primary"
                        href="{{ url('users/switch-back') }}"
                    >
                        <i class="nav-icon fas fa-undo"></i>
                        @lang('layout.sidebar.switch-back')
                    </a>
                </li>
            @endif
			@if (!Auth::user()->isSuperAdmin())
				@if (isset($totalClinicAssign) && $totalClinicAssign > 1 )
					<li class="nav-item mt-auto">
						
						{!!  Form::select('switch_clinic',$assignedClinics, '', ['onchange'=>'switch_domain(this.value);','class' => 'form-control','id' => 'switch_clinic' ]) !!}
						
					</li>
				@endif
				{!!
                                Form::open([
                                    'class' => 'd-inline-block',
                                    'method' => 'POST',
									'id' => 'switchclinic',
                                    'url' => url("admin/users/switch-clinic/"),
                                ])
                            !!}
                            {{ Form::hidden('clinic_id', '',['id'=>'clinic_id']) }}
                {!! Form::close() !!}
				@if (Session::get('original_clinic'))
					<li class="nav-item mt-auto">
						<a
							class="nav-link nav-link-primary bg-primary"
							href="{{ url('admin/users/switch-clinic-back') }}"
						>
							<i class="nav-icon fas fa-undo"></i>
							@lang('layout.sidebar.switch-clinic')
						</a>
					</li>
				@endif
			@endif
        </ul>
    </nav>

    <button
        class="sidebar-minimizer brand-minimizer"
        type="button"
    ></button>
</div>
<script>

	function switch_domain(selval) {
		$('#clinic_id').val(selval);
		document.getElementById("switchclinic").submit(); 
	}

</script>