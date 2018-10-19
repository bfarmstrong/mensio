<div class="form-row">
    <div class="form-group col-12 col-md-8">
        {!!
            Form::label(
                'address_line_1',
                __('partials.form-address.address-line-1')
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
                __('partials.form-address.address-line-2')
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
                __('partials.form-address.city')
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
                __('partials.form-address.postal-code')
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
                __('partials.form-address.province')
            )
        !!}

        {!! Form::hidden('_province', $province ?? null) !!}
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
                __('partials.form-address.country')
            )
        !!}

        {!!
            Form::select(
                'country',
                Countries::all()->map(function ($country) {
                    return $country->get('name.common');
                }),
                old('country') ?? 'CAN',
                ['class' => 'form-control countrypicker selectpicker']
            )
        !!}
    </div>
</div>
