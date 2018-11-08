<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
            {!!
                Form::file(
                    'signature_file',
                    [
                        'class' => 'custom-file-input',
                        'id' => 'signature_file',
                    ]
                )
            !!}

            {!!
                Form::label(
                    'signature_file',
                    __('user.form-signature.signature-file'),
                    ['class' => 'custom-file-label']
                )
            !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'signature_base64',
                __('user.form-signature.signature-base64')
            )
        !!}

        {!! Form::hidden('signature_base64', null) !!}

        <div class="d-block w-100">
            <canvas class="signature-pad border" height="300"></canvas>
        </div>
    </div>
</div>

@isset ($user->written_signature)
    <div class="form-row">
        <div class="form-group col-12">
            {!!
                Form::label(
                    null,
                    __('user.form-signature.current-signature')
                )
            !!}

            <img
                class="border img-fluid mx-auto d-block"
                src="/user/signature/download"
            />
        </div>
    </div>
@endisset

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('user.form-signature.save'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    window.$('.custom-file-input').change(function (event) {
        window.$(this).next('.custom-file-label').html(event.target.files[0].name);
    });
</script>
@endpush

