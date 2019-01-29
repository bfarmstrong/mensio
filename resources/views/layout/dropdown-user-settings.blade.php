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
		@if (Auth::user()->gender == 'Male')
			<img id="gen" width="20px" height="20px" src="https://user-images.githubusercontent.com/45040226/51488810-941f4580-1d74-11e9-8df9-5f8a0a9b74b1.png" />
			
		@elseif (Auth::user()->gender == 'Female')
			<img id="gen" width="20px" height="20px" src="https://user-images.githubusercontent.com/45040226/51488809-9386af00-1d74-11e9-90ae-f5273f6d9ce5.png" />
		@else
            <i class="fas fa-user"></i>
		@endif
            @lang('layout.dropdown-user-settings.profile')
        </a>

        <a class="dropdown-item" href="{{ url('user/password') }}">
            <i class="fas fa-asterisk"></i>
            @lang('layout.dropdown-user-settings.change-password')
        </a>

        @if (Auth::user()->isTherapist() || Auth::user()->isAdmin())
            <a
                class="dropdown-item {{ ($requiresSignature ?? false) ? 'font-weight-bold' : '' }}"
                href="{{ url('user/signature') }}"
            >
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
