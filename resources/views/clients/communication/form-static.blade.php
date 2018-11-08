<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'appointment_date',
                __('clients.communication.form-static.appointment-date')
            )
        !!}

        <p class="form-control-static">
            {{ $communication->appointment_date }}
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'reason',
                __('clients.communication.form-static.reason')
            )
        !!}

        <p class="form-control-static">
            {{ $communication->reason }}
        </p>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'notes',
                __('clients.communication.form-static.notes')
            )
        !!}

        <pre class="form-control-static">{{ $communication->notes }}</pre>
    </div>
</div>
