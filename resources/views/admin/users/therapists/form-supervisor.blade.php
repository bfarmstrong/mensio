<div class="input-group">
    {!!
        Form::select(
            'supervisor_id',
            $supervisors->pluck('name', 'id'),
            old('therapist_id') ?? $supervisor,
            [
                'class' => 'form-control selectpicker',
                'placeholder' => 'Select',
            ]
        )
    !!}

    <div class="input-group-append">
        {!!
            Form::submit(
                __('admin.users.therapists.form-supervisor.save'),
                ['class' => 'btn btn-outline-primary']
            )
        !!}
    </div>
</div>
