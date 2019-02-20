@extends('layout.dashboard')

@section('title', __('admin.form-client.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.invite-client'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.form-client.title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/invite-client')
                ])
            !!}
        <div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!!
                Form::label(
                    'email',
                    __('admin.form-client.email')
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
                    __('admin.form-client.name')
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
                __('admin.form-client.phone')
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
                __('admin.form-client.home-phone')
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
                __('admin.form-client.work-phone')
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
    <div class="form-group col-6">
        {!!
            Form::label(
                'fees',
                __('admin.form-client.fees')
            )
        !!}

        {!!
                Form::text(
                    'fees',
                    old('fees'),
                    ['class' => 'form-control']
                )
       !!}
    </div>
	<div class="form-group col-6">
        {!!
            Form::label(
                'language',
                __('admin.form-client.language')
            )
        !!}

        {!!
            Form::select(
                'language',
                [
                    'English' => __('admin.form-client.english')
                ],
                old('language'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!!
            Form::label(
                'referrer_id',
                __('admin.form-client.referrer')
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
	<div class="form-group col-6">
        {!!
            Form::label(
                'gender',
                __('admin.form-client.gender')
            )
        !!}

        {!!
            Form::select(
                'gender',
                [
                    'Male' => __('user.form-settings.male'),
                    'Female' => __('user.form-settings.female'),
                    'Other' => __('user.form-settings.other'),
                ],
                old('gender'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>
   <div class="form-row">
        <div class="form-group col-12">
            {!!
                Form::label(
                    'license',
                    __('admin.form-client.license')
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

@if (isset($roles))
    <div class="form-row">
        <div class="form-group col-12">
            {!!
                Form::label(
                    'role_id',
                    __('admin.form-client.role')
                )
            !!}

            {!!
                Form::select(
                    'role_id[]',
                    $roles->pluck('label', 'id'),
                    old('role_id'),
                    ['class' => 'form-control selectpicker','placeholder' => 'Select',]
                )
            !!}
	
        </div>
    </div>
@endif

<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('admin.form-client.address')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'address_line_1',
                __('admin.form-client.address-line-1')
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
                __('admin.form-client.address-line-2')
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
                __('admin.form-client.city')
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
                __('admin.form-client.postal-code')
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
                __('admin.form-client.province')
            )
        !!}

        {!! Form::hidden('_province', $user->province ?? $currentClinic->province) !!}
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
                __('admin.form-client.country')
            )
        !!}

        {!!
            Form::select(
                'country',
                Countries::all()->map(function ($country) {
                    return $country->get('name.common');
                }),
                old('country') ?? $currentClinic->country,
                ['class' => 'form-control countrypicker selectpicker']
            )
        !!}
    </div>
</div>
<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('admin.form-client.emergency-contact')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-lg-4">
        {!!
            Form::label(
                'emergency_name',
                __('admin.form-client.emergency-name')
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
                __('admin.form-client.emergency-phone')
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
                __('admin.form-client.emergency-relationship')
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
<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('admin.form-client.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}
        </div>
    </div>
</div>   

            {!! Form::close() !!}
        </div>
    </div>
@endsection
