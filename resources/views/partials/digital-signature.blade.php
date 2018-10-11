<div class="form-row bg-light border p-3 mb-3">
    <div class="form-group col-12">
        <p class="lead mb-0">
            @lang('partials.digital-signature.title')
        </p>
    </div>

    <div class="form-group col-12 col-md-6 col-lg-9">
        {!!
            Form::label(
                'signature[name]',
                __('partials.digital-signature.name'),
                ['class' => 'font-weight-bold']
            )
        !!}

        {!!
            Form::text(
                'signature[name]',
                old('signature[name]'),
                ['class' => 'form-control']
            )
        !!}

        <small class="form-text text-muted d-none d-md-inline-block">
            @lang('partials.digital-signature.signature-notice')
        </small>
    </div>

    <div class="form-group col-12 col-md-6 col-lg-3">
        {!!
            Form::label(
                'signature[license]',
                __('partials.digital-signature.license'),
                ['class' => 'font-weight-bold']
            )
        !!}

        {!!
            Form::text(
                'signature[license]',
                old('signature[license]'),
                ['class' => 'form-control']
            )
        !!}

        <small class="form-text text-muted d-inline-block d-md-none">
            @lang('partials.digital-signature.signature-notice')
        </small>
    </div>
</div>
