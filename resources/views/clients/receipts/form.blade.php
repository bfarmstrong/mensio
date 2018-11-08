<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'appointment_date',
                __('clients.receipts.form.appointment-date')
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
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('clients.receipts.form.submit'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
