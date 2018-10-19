
<div class="row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            {!!
                Form::label(
                    'email',
                    __('user.form-settings.email')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                {!!
                    Form::email(
                        'email',
                        old('email'),
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            {!!
                Form::label(
                    'name',
                    __('user.form-settings.name')
                )
            !!}

            {!!
                Form::text(
                    'name',
                    old('name'),
                    ['class' => 'form-control']
                )
            !!}
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            {!!
                Form::label(
                    'phone',
                    __('user.form-settings.phone')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>

                {!!
                    Form::tel(
                        'phone',
                        old('phone'),
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>
</div>

@if ($features['license'] ?? false)
    <div class="form-row">
        <div class="form-group col-12">
            {!!
                Form::label(
                    'license',
                    __('user.form-settings.license')
                )
            !!}

            {!!
                Form::text(
                    'license',
                    old('license'),
                    ['class' => 'form-control']
                )
            !!}
        </div>
    </div>
@endif

@if (Auth::user()->isAdmin() && isset($roles))
    <div class="form-row">
        <div class="form-group col-12">
            {!!
                Form::label(
                    'role_id',
                    __('user.form-settings.role')
                )
            !!}

            {!!
                Form::select(
                    'role_id',
                    $roles->pluck('label', 'id'),
                    old('role_id'),
                    ['class' => 'form-control selectpicker']
                )
            !!}
        </div>
    </div>
@endif

<hr class="mt-1">

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <div class="custom-control custom-checkbox mb-2">
                {!!
                    Form::checkbox(
                        'marketing',
                        1,
                        old('marketing'),
                        [
                            'class' => 'custom-control-input',
                            'id' => 'marketing',
                        ]
                    )
                !!}

                {!!
                    Form::label(
                        'marketing',
                        __('user.form-settings.agree-marketing'),
                        ['class' => 'custom-control-label']
                    )
                !!}
            </div>

            @unless (isset($user->id))
                @if (Auth::user()->isAdmin())
                    {!! Form::hidden('terms_and_cond', 1) !!}
                @else
                    <div class="custom-control custom-checkbox">
                        {!!
                            Form::checkbox(
                                'terms_and_cond',
                                1,
                                old('terms_and_cond'),
                                [
                                    'class' => 'custom-control-input',
                                    'id' => 'terms_and_cond',
                                ]
                            )
                        !!}

                        {!!
                            Form::label(
                                'terms_and_cond',
                                __('user.form-settings.agree-terms'),
                                ['class' => 'custom-control-label']
                            )
                        !!}
                    </div>
                @endif
            @endunless
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('user.form-settings.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}

            @if (($features['switch_user'] ?? false) && !Session::get('original_user'))
                <a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/switch/$user->id") }}"
                >
                    @lang('user.form-settings.switch-user')
                </a>
            @endif

            @if ($features['change_password'] ?? false)
                <a
                    class="btn btn-secondary"
                    href="{{ url('user/password') }}"
                >
                    @lang('user.form-settings.change-password')
                </a>
            @endif

            @if ($features['therapists'] ?? false)
                <a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/$user->id/therapists") }}"
                >
                    @lang('user.form-settings.therapists')
                </a>
            @endif
			@if ($features['license'] ?? false)
				<a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/$user->id/groups") }}"
                >
                    @lang('user.form-settings.groups')
                </a>
			@endif
        </div>
    </div>
</div>
