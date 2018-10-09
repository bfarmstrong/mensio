<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'name',
                    __('admin.roles.form.name')
                )
            !!}
            {!!
                Form::text(
                    'name',
                    old('name'),
                    [
                        'class' => 'form-control',
                        'id' => 'name',
                        'readonly' => isset($role),
                    ]
                )
            !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'label',
                    __('admin.roles.form.label')
                )
            !!}

            {!!
                Form::text(
                    'label',
                    old('label'),
                    [
                        'class' => 'form-control',
                        'id' => 'label',
                    ]
                )
            !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'level',
                    __('admin.roles.form.level')
                )
            !!}

            {!!
                Form::number(
                    'level',
                    old('level'),
                    [
                        'class' => 'form-control',
                        'id' => 'level',
                    ]
                )
            !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('admin.roles.form.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}
        </div>
    </div>
</div>
