{!! Form::hidden('token', $token) !!}

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
                'placeholder' => __('auth.passwords.form-reset-password.email-placeholder'),
            ]
        )
    !!}

    @include('partials.input-error', ['name' => 'email'])
</div>

<div class="input-group mb-3">
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
                'placeholder' => __('auth.passwords.form-reset-password.password-placeholder'),
            ]
        )
    !!}

    @include('partials.input-error', ['name' => 'password'])
</div>

<div class="input-group mb-4">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="fas fa-asterisk"></i>
        </div>
    </div>

    {!!
        Form::password(
            'password_confirmation',
            [
                'class' => 'form-control ' . $errors->first('password_confirmation', 'is-invalid'),
                'placeholder' => __('auth.passwords.form-reset-password.password-confirmation-placeholder'),
            ]
        )
    !!}

    @include('partials.input-error', ['name' => 'password_confirmation'])
</div>

<div class="row">
    <div class="col-6">
        {!!
            Form::submit(
                __('auth.passwords.form-reset-password.submit'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
