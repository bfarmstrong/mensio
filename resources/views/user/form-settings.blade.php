
<div class="row">
    <div class="col-12">
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
</div>

<div class="row">
    <div class="col-12">
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
</div>

<div class="row">
    <div class="col-12">
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

@if (isset($user) && ($user->role->first()->name === 'admin' || $user->id == 1))
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                @input_maker_label(
                    __('user.form-settings.role'),
                    ['name' => 'roles']
                )
                @input_maker_create(
                    'roles',
                    [
                        'label' => 'label',
                        'model' => 'App\Models\Role',
                        'type' => 'relationship',
                        'value' => 'name',
                    ],
                    $user
                )
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <div class="custom-control custom-checkbox mb-2">
                {!!
                    Form::checkbox(
                        'marketing',
                        null,
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

            <div class="custom-control custom-checkbox">
                {!!
                    Form::checkbox(
                        'terms_and_cond',
                        null,
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

            @if ($features['switch_user'] ?? false)
                <a
                    class="btn btn-link"
                    href="{{ url("admin/users/switch/$user->id") }}"
                >
                    @lang('user.form-settings.switch-user')
                </a>
            @endif

            @if ($features['change_password'] ?? false)
                <a
                    class="btn btn-link"
                    href="{{ url('user/password') }}"
                >
                    @lang('user.form-settings.change-password')
                </a>
            @endif

            @if ($features['therapists'] ?? false)
                <a
                    class="btn btn-link"
                    href="{{ url("admin/users/$user->id/therapists") }}"
                >
                    @lang('user.form-settings.therapists')
                </a>
            @endif
        </div>
    </div>
</div>
