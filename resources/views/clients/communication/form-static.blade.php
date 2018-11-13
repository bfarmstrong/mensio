<div class="form-row">
    <div class="form-group col-12 mb-0">
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
    <div class="form-group col-12 mb-0">
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
    <div class="form-group col-12 mb-0">
        {!!
            Form::label(
                'notes',
                __('clients.communication.form-static.notes')
            )
        !!}

        <pre class="bg-light border p-3 form-control-static">{{ $communication->notes }}</pre>

        @if ($communication->isSignatureValid($communication->therapist_id))
            <i class="fas fa-lock text-success pull-right"></i>
        @else
            <i
                class="fas fa-exclamation-triangle text-danger pull-right"
                data-toggle="tooltip"
                data-placement="top"
                title="{{ __('clients.communication.form-static.signature-invalid') }}"
            >
            </i>
        @endif
    </div>
</div>
