@extends('layout.dashboard')

@section('title', __('admin.form-therapist.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.invite-therapist'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus mr-1"></i>
            @lang('admin.form-therapist.title')
        </div>

        <div class="card-body">
            {!!
                Form::open([
                    'url' => url('admin/invite-therapist')
                ])
            !!}
        <div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {!!
                Form::label(
                    'email',
                    __('admin.form-therapist.email')
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
                    __('admin.form-therapist.name')
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
                __('admin.form-therapist.phone')
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
                __('admin.form-therapist.home-phone')
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
                __('admin.form-therapist.work-phone')
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
                    'license',
                    __('admin.form-therapist.license')
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
                    __('admin.form-therapist.role')
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
	<div class="form-row">
        <div class="form-group col-12"> 
			{!!
                Form::label(
                    'supervisor_id',
                    __('admin.form-therapist.supervisor')
                )
            !!}
             {!!
				Form::select(
					'supervisor_id',
					$supervisors->pluck('name', 'id'),
					old('supervisor_id'),
					[
						'class' => 'form-control selectpicker',
						'placeholder' => 'Select',
					]
				)
			!!}


	
        </div>
    </div>
<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('admin.form-therapist.address')
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'address_line_1',
                __('admin.form-therapist.address-line-1')
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
                __('admin.form-therapist.address-line-2')
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
                __('admin.form-therapist.city')
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
                __('admin.form-therapist.postal-code')
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
                __('admin.form-therapist.province')
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
                __('admin.form-therapist.country')
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


<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('admin.form-therapist.save'),
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
