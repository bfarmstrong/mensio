<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
            {!!
                Form::file(
                    'file',
                    [
                        'class' => 'custom-file-input',
                        'id' => 'file',
                    ]
                )
            !!}

            {!!
                Form::label(
                    'file',
                    __('clients.attachments.form.file'),
                    ['class' => 'custom-file-label']
                )
            !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('clients.attachments.form.submit'),
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
