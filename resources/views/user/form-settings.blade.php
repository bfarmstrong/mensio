<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('user.form-settings.basic-information')
        </p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
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

    <div class="col-12 col-md-6">
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

<div class="form-row">
    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'phone',
                __('user.form-settings.phone')
            )
        !!}

        {!!
            Form::tel(
                'phone',
                old('phone'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'home_phone',
                __('user.form-settings.home-phone')
            )
        !!}

        {!!
            Form::tel(
                'home_phone',
                old('home_phone'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'work_phone',
                __('user.form-settings.work-phone')
            )
        !!}

        {!!
            Form::tel(
                'work_phone',
                old('work_phone'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'preferred_contact_method',
                __('user.form-settings.preferred-contact-method')
            )
        !!}

        {!!
            Form::select(
                'preferred_contact_method',
                [
                    'EM' => __('user.form-settings.contact-email'),
                    'PH' => __('user.form-settings.contact-phone'),
                ],
                old('preferred_contact_method'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'doctor_id',
                __('user.form-settings.doctor')
            )
        !!}

        {!!
            Form::select(
                'doctor_id',
                $doctors->pluck('name', 'id'),
                old('doctor_id'),
                [
                    'class' => 'form-control selectpicker',
                    'data-live-search' => 'true',
                ]
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'referrer_id',
                __('user.form-settings.referrer')
            )
        !!}

        {!!
            Form::select(
                'referrer_id',
                $doctors->pluck('name', 'id'),
                old('referrer_id'),
                [
                    'class' => 'form-control selectpicker',
                    'data-live-search' => 'true',
                ]
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'health_card_number',
                __('user.form-settings.health-card-number')
            )
        !!}

        {!!
            Form::text(
                'health_card_number',
                old('health_card_number'),
                ['class' => 'form-control']
            )
        !!}
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

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('user.form-settings.address')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'address_line_1',
                __('user.form-settings.address-line-1')
            )
        !!}

        {!!
            Form::text(
                'address_line_1',
                old('address_line_1'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'address_line_2',
                __('user.form-settings.address-line-2')
            )
        !!}

        {!!
            Form::text(
                'address_line_2',
                old('address_line_2'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'city',
                __('user.form-settings.city')
            )
        !!}

        {!!
            Form::text(
                'city',
                old('city'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-4">
        {!!
            Form::label(
                'postal_code',
                __('user.form-settings.postal-code')
            )
        !!}

        {!!
            Form::text(
                'postal_code',
                old('postal_code'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'province',
                __('user.form-settings.province')
            )
        !!}

        {!! Form::hidden('_province', $user->province ?? null) !!}
        {!!
            Form::select(
                'province',
                [],
                old('province'),
                ['class' => 'form-control provincepicker selectpicker']
            )
        !!}
    </div>

    <div class="form-group col-12 col-md-6">
        {!!
            Form::label(
                'country',
                __('user.form-settings.country')
            )
        !!}

        {!!
            Form::select(
                'country',
                Countries::all()->map(function ($country) {
                    return $country->get('name.common');
                }),
                old('country') ?? 'CAN',
                ['class' => 'form-control countrypicker selectpicker']
            )
        !!}
    </div>
</div>

<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('user.form-settings.emergency-contact')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-lg-4">
        {!!
            Form::label(
                'emergency_name',
                __('user.form-settings.emergency-name')
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
                __('user.form-settings.emergency-phone')
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
                __('user.form-settings.emergency-relationship')
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
                __('user.form-settings.notes')
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
