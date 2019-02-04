<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!!
                Form::label(
                    'first_name',
                    __('user.form-client.first_name')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                {!!
                    Form::text(
                        'first_name',
                        old('first_name'),
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            {!!
                Form::label(
                    'last_name',
                    __('user.form-client.last_name')
                )
            !!}

            {!!
                Form::text(
                    'last_name',
                    old('last_name'),
                    ['class' => 'form-control']
                )
            !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'address',
                __('user.form-client.address')
            )
        !!}

        {!!
            Form::text(
                'address',
                old('address'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'telephone_number',
                __('user.form-client.telephone_number')
            )
        !!}

        {!!
            Form::tel(
                'telephone_number',
                old('telephone_number'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'referring_physician',
                __('user.form-client.referring_physician')
            )
        !!}

        {!!
            Form::tel(
                'referring_physician',
                old('referring_physician'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!!
            Form::label(
                'birth_date',
                __('user.form-client.birth_date')
            )
        !!}

        {!!
            Form::text(
                'birth_date',
                old('birth_date'),
                ['class' => 'form-control']
            )
        !!}
    </div>
	<div class="form-group col-6">
        {!!
            Form::label(
                'secondary_telephone_number',
                __('user.form-client.secondary_telephone_number')
            )
        !!}

        {!!
            Form::text(
                'secondary_telephone_number',
                old('secondary_telephone_number'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'language',
                __('user.form-client.language')
            )
        !!}

        {!!
            Form::text(
                'language',
                old('language'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'fee',
                __('user.form-client.fee')
            )
        !!}

        {!!
            Form::text(
                'fee',
                old('fee'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'ramq',
                __('user.form-client.ramq')
            )
        !!}

        {!!
            Form::text(
                'ramq',
                old('ramq'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>


<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('user.form-client.address')
        </p>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'referrer',
                __('user.form-client.referrer')
            )
        !!}

        {!!
            Form::text(
                'referrer',
                old('referrer'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'gender',
                __('user.form-client.gender')
            )
        !!}

        {!!
            Form::text(
                'gender',
                old('gender'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>


<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('user.form-client.emergency-contact')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-lg-4">
        {!!
            Form::label(
                'emergency_name',
                __('user.form-client.emergency-name')
            )
        !!}

        {!!
            Form::text(
                'emergency_name',
                old('emergency_name'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-6 col-lg-4">
        {!!
            Form::label(
                'emergency_phone',
                __('user.form-client.emergency-phone')
            )
        !!}

        {!!
            Form::text(
                'emergency_phone',
                old('emergency_phone'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-6 col-lg-4">
        {!!
            Form::label(
                'emergency_relationship',
                __('user.form-client.emergency-relationship')
            )
        !!}

        {!!
            Form::text(
                'emergency_relationship',
                old('emergency_relationship'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<hr class="mt-1">

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'notes',
                __('user.form-client.notes')
            )
        !!}

        {!!
            Form::textarea(
                'notes',
                old('notes'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

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
                        __('user.form-client.agree-marketing'),
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
                                __('user.form-client.agree-terms'),
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
                    __('user.form-client.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}

            @if (($features['switch_user'] ?? false) && !Session::get('original_user'))
                <a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/switch/$user->id") }}"
                >
                    @lang('user.form-client.switch-user')
                </a>
            @endif

            @if ($features['change_password'] ?? false)
                <a
                    class="btn btn-secondary"
                    href="{{ url('user/password') }}"
                >
                    @lang('user.form-client.change-password')
                </a>
            @endif

            @if ($features['change_signature'] ?? false)
                <a
                    class="btn btn-secondary"
                    href="{{ url('user/signature') }}"
                >
                    @lang('user.form-client.change-signature')
                </a>
            @endif

            @if ($features['therapists'] ?? false)
                <a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/$user->id/therapists") }}"
                >
                    @lang('user.form-client.therapists')
                </a>
            @endif

			@if ($features['groups'] ?? false)
				<a
                    class="btn btn-secondary"
                    href="{{ url("admin/users/$user->id/groups") }}"
                >
                    @lang('user.form-client.groups')
                </a>
            @endif

            @if ($features['active'] ?? false)
                @if ($user->is_active == 1)
                    <a
                        class="btn btn-danger"
                        href="{{ url("admin/users/inactivate/$user->id") }}"
                    >
                        @lang('user.form-client.inactive')
                    </a>
                @else
                    <a
                        class="btn btn-success"
                        href="{{ url("admin/users/activate/$user->id") }}"
                    >
                        @lang('user.form-client.active')
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>
