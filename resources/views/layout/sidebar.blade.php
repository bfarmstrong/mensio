<div class="sidebar sidebar-show">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('layout.sidebar.menu')
            </li>
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
			@if (Auth::user()->isSuperAdmin())
				 <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fas fa-user-tie"></i>
                        @lang('layout.sidebar.superadmin')
                    </a>
					<ul class="nav-dropdown-items" style="padding-left: 15px;list-style: none;">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/clinics') }}"
                            >
                                <i class="nav-icon fas fa-hospital"></i>
                                @lang('layout.sidebar.clinics')
                            </a>
                        </li>
                    </ul>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item nav-dropdown open">
                            <a
                                class="nav-link nav-dropdown-toggle"
                                href="{{ url('admin/users') }}"
                            >
                                <i class="nav-icon fas fa-user-friends"></i>
                                @lang('layout.sidebar.all-users')
							</a>
							<ul class="nav-dropdown-items" style="padding-left: 15px;list-style: none;">
								<li >
									<a
										class="nav-link "
										href="{{ url('admin/therapists') }}"
									>
									<i class="nav-icon fas fa-user-friends"></i>
									 @lang('layout.sidebar.all-therapist') </a>
								</li>
								<li >
								<a
										class="nav-link "
										href="{{ url('admin/clients') }}"
									>
									<i class="nav-icon fas fa-users"></i>
									 @lang('layout.sidebar.all-clients') </a>
								</li>
							</ul>
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
            @if (Auth::user()->isAdmin())
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fas fa-user-tie"></i>
                        @lang('layout.sidebar.admin')
                    </a>

                    <ul class="nav-dropdown-items" style="padding-left: 15px;list-style: none;">
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
                                href="{{ url('admin/surveys') }}"
                            >
                                <i class="nav-icon fas fa-poll"></i>
                                @lang('layout.sidebar.surveys')
                            </a>
                        </li>
                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="{{ url('admin/groups') }}"
                            >
                                <i class="nav-icon fas fa-user-plus"></i>
                                @lang('layout.sidebar.group-management')
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
					</ul>
				</li>
				@endif


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
			@endcan

            @if (Auth::user()->isClient())
			<li class="nav-item nav-dropdown open">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-user-tie"></i>
                        @lang('layout.sidebar.client')
                </a>
				<ul class="nav-dropdown-items" style="padding-left: 15px;list-style: none;">
					<li class="nav-item">
						<a
							class="nav-link"
							href="{{ url('responses') }}"
						>
							<i class="nav-icon fas fa-question"></i>
							@lang('layout.sidebar.questionnaires')
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
				</ul>
			</li>
            @endif

            @if (!Auth::user()->isSuperAdmin())
                @if (isset($availableClinics) && $availableClinics->isNotEmpty() )
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-hospital"></i>
                            @lang('layout.sidebar.my-clinics')
                        </a>

                        <ul class="nav-dropdown-items">
                            @foreach ($availableClinics as $clinic)
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ ($currentClinic->id ?? null) === $clinic->id ? 'active' : '' }}"
                                        href="{{ str_replace_first('//', '//' . $clinic->subdomain . '.', config('app.url')) }}"
                                        target="_blank"
                                    >
                                        {{ $clinic->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
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
        </ul>
    </nav>

    <button
        class="sidebar-minimizer brand-minimizer"
        type="button"
    ></button>
</div>
