<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'therapist_id',
                __('admin.users.therapists.form-add.name')
            )
        !!}

        {!!
            Form::select(
                'therapist_id',
                $therapists->pluck('name', 'id'),
                old('therapist_id'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('admin.users.therapists.form-add.save'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
