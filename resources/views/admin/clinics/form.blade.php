<div class="form-row">
    <div class="form-group col-md-12 col-lg-6">
        {!! Form::label('name', __('admin.clinics.form.name')) !!}

        {!!
            Form::text(
                'name',
                old('name'),
                ['class' => 'form-control']
            )
        !!}
    </div>

    <div class="form-group col-12 col-lg-6">
        {!! Form::label('subdomain', __('admin.clinics.form.subdomain')) !!}

        {!!
            Form::text(
                'subdomain',
                old('subdomain'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<hr class="mt-1">

<div class="form-row">
    <div class="col-12">
        <p class="h5">
            @lang('admin.clinics.form.address')
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
