<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'appointment_date',
                __('clients.communication.form.appointment-date')
            )
        !!}

        {!!
            Form::date(
                'appointment_date',
                old('appointment_date') ?? date('Y-m-d'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'reason',
                __('clients.communication.form.reason')
            )
        !!}

        {!!
            Form::text(
                'reason',
                old('reason'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'notes',
                __('clients.communication.form.notes')
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

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('clients.communication.form.submit'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>

