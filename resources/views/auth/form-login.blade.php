<div class="input-group mb-3">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="fas fa-user"></i>
        </div>
    </div>

    {!!
        Form::email(
            'email',
            old('email'),
            [
                'class' => 'form-control ' . $errors->first('email', 'is-invalid'),
                'placeholder' => __('auth.form-login.email-placeholder'),
            ]
        )
    !!}

    @include('partials.input-error', ['name' => 'email'])
</div>

<div class="input-group mb-4">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="fas fa-asterisk"></i>
        </div>
    </div>

    {!!
        Form::password(
            'password',
            [
                'class' => 'form-control ' . $errors->first('password', 'is-invalid'),
                'placeholder' => __('auth.form-login.password-placeholder'),
            ]
        )
    !!}

    @include('partials.input-error', ['name' => 'password'])
</div>

<div class="form-group">
    <div class="custom-control custom-checkbox">
        {!!
            Form::checkbox(
                'remember',
                null,
                old('remember'),
                [
                    'class' => 'custom-control-input',
                    'id' => 'form-login-remember-me',
                ]
            )
        !!}

        {!!
            Form::label(
                'form-login-remember-me',
                __('auth.form-login.remember-me'),
                ['class' => 'custom-control-label']
            )
        !!}
    </div>
</div>

<div class="row">
    <div class="col-6">
        {!!
            Form::submit(
                __('auth.form-login.submit'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>

    <div class="col-6 text-right">
        <a
            class="btn btn-link px-0"
            href="{{ url('password/reset') }}"
        >
            @lang('auth.form-login.forgot-password')
        </a>
    </div>
</div>
