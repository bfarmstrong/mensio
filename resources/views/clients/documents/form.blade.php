<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
             {!!
				Form::label(
					'name',
					__('admin.documents.form.name')
				)
			!!}

			{!!
				Form::text(
					'name',
					old('name'),
					['class' => 'form-control']
				)
			!!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
             {!!
				Form::label(
					'description',
					__('admin.documents.form.description')
				)
			!!}

			{!!
				Form::text(
					'description',
					old('description'),
					['class' => 'form-control']
				)
			!!}
        </div>
    </div>
</div> 
<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
             {!!
				Form::label(
					'document_type',
					__('admin.documents.form.document_type')
				)
			!!}

		{!!
            Form::select(
                'document_type',
				[1=>'Notes',2 => "Other Attachments"],
				old('document_type'),
                ['class' => 'form-control selectpicker']
            )
        !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12">
        <div class="custom-file">
            {!!
                Form::file(
                    'file',
                    [
                        'class' => 'custom-file-input',
                        'id' => 'file',
						'multiple' => 'multiple'
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
@include('partials.digital-signature')
<div class="form-row">
    <div class="form-group col-12 mb-0">
        <button
            class="btn btn-primary"
            name="is_signed"
            type="submit"
            value="1"
        >
            <i class="fas fa-file-signature mr-1"></i>
				 @lang('clients.documents.form.signed')
        </button>

        
            <button
                class="btn btn-secondary"
                name="is_signed"
                type="submit"
                value="0"
            >
                 @lang('clients.documents.form.unsigned')
            </button>
        
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    window.$('.custom-file-input').change(function (event) {
        window.$(this).next('.custom-file-label').html(event.target.files[0].name);
    });
</script>
@endpush
