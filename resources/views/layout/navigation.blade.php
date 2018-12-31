<header class="app-header navbar">
    <a
        class="navbar-brand text-dark"
        @if (Auth::user()->isAdmin())
        href="{{ url('admin/dashboard') }}"
        @else
        href="{{ url('dashboard') }}"
        @endif
    >
        @lang('dashboard.navigation-brand')
    </a>

    <button
        aria-expanded="false"
        aria-label="{{ __('layout.navigation.toggle-sidebar') }}"
        class="navbar-toggler sidebar-toggler mr-auto"
        data-toggle="sidebar-show"
        type="button"
    >
        <span class="navbar-toggler-icon"></span>
    </button>

    <span class="ml-auto">
        <ul class="nav navbar-nav">
            @if ($requiresSignature ?? false)
                <li>
                    <i
                        class="fas fa-exclamation-triangle text-danger mr-1"
                        data-placement="bottom"
                        data-toggle="tooltip"
                        title="{{ __('layout.navigation.signature-required') }}"
                    >
                    </i>
                </li>
            @endif
            @include('layout.dropdown-user-settings')
        </ul>
    </span>
</header>
