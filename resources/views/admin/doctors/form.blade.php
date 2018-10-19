<div class="form-row">
    <div class="form-group col-md-12 col-lg-9">
        {!! Form::label('name', __('admin.doctors.form.name')) !!}

        {!!
            Form::text(
                'name',
                old('name'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-lg-3">
        {!! Form::label('specialty', __('admin.doctors.form.specialty')) !!}

        {!!
            Form::text(
                'specialty',
                old('specialty'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('email', __('admin.doctors.form.email')) !!}

        {!!
            Form::email(
                'email',
                old('email'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('phone', __('admin.doctors.form.phone')) !!}

        {!!
            Form::tel(
                'phone',
                old('phone'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('admin.doctors.form.address')
        </p>
    </div>
</div>

@include('partials.form-address', [
    'province' => $doctor->province ?? null,
])

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::submit(
                __('admin.doctors.form.save'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
