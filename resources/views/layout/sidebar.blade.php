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
            @endcan

            @if (Auth::user()->hasAtLeastRole('admin'))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fas fa-user-tie"></i>
                        @lang('layout.sidebar.admin')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ url('admin/dashboard') }}"
                            >
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                @lang('layout.sidebar.dashboard')
                            </a>
                        </li>

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
        </ul>
    </nav>

    <button
        class="sidebar-minimizer brand-minimizer"
        type="button"
    ></button>
</div>
