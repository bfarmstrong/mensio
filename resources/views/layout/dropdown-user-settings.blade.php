<li class="nav-item dropdown">
    <a
        aria-expanded="false"
        aria-haspopup="true"
        class="nav-link nav-link"
        data-toggle="dropdown"
        href="#"
        role="button"
    >
        <i class="fas fa-user-circle fa-2x"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-header text-center">
            <strong>
                @lang('layout.dropdown-user-settings.settings')
            </strong>
        </div>

        <a class="dropdown-item" href="{{ url('user/settings') }}">
            <i class="fas fa-user"></i>
            @lang('layout.dropdown-user-settings.profile')
        </a>

        <a class="dropdown-item" href="{{ url('user/password') }}">
            <i class="fas fa-asterisk"></i>
            @lang('layout.dropdown-user-settings.change-password')
        </a>

        @if (Auth::user()->isTherapist())
            <a class="dropdown-item" href="{{ url('user/signature') }}">
                <i class="fas fa-signature"></i>
                @lang('user.form-settings.change-signature')
            </a>
        @endif

        <a class="dropdown-item" href="{{ url('logout') }}">
            <i class="fas fa-sign-out-alt"></i>
            @lang('layout.dropdown-user-settings.sign-out')
        </a>
    </div>
</li>
