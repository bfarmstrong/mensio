<div class="row">
    <div class="col-12">
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
                        'placeholder' => __('auth.passwords.form-forgot-password.email-placeholder'),
                    ]
                )
            !!}

            @include('partials.input-error', ['name' => 'email'])
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        {!!
            Form::submit(
                __('auth.passwords.form-forgot-password.submit'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>

    <div class="col-6 text-right">
        <a
            class="btn btn-link"
            href="{{ url('login') }}"
        >
            @lang('auth.passwords.form-forgot-password.login')
        </a>
    </div>
</div>
