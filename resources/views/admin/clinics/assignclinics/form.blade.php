{!! Form::hidden('clinic_id', $clinic->id) !!}

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'user_id',
                __('admin.clinics.assignclinic.user')
            )
        !!}

        {!!
            Form::select(
                'user_id',
                $clients->pluck('name', 'id'),
                old('user_id'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('admin.clinics.assignclinic.form-assign-button'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
