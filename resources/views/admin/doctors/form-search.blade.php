<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-search"></i>
            </div>
        </div>

        {!!
            Form::text(
                'search',
                old('search'),
                [
                    'class' => 'form-control',
                    'placeholder' => __('admin.doctors.form-search.search'),
                ]
            )
        !!}

        <div class="input-group-append">
            {!!
                Form::submit(
                    __('admin.doctors.form-search.submit'),
                    ['class' => 'btn btn-outline-secondary']
                )
            !!}
        </div>
    </div>
</div>
