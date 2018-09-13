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
                    ]
                )
            !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group mb-2">
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

<hr>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <h4 class="mb-3">
                @lang('admin.roles.form.permissions')
            </h4>

            @foreach(Config::get('permissions', []) as $permission => $name)
                <div class="custom-control custom-checkbox mb-2">
                    {!!
                        Form::checkbox(
                            "permissions[$permission]",
                            $name,
                            old("permissions[$permission]"),
                            [
                                'class' => 'custom-control-input',
                                'id' => $name,
                            ]
                        )
                    !!}

                    {!!
                        Form::label(
                            $name,
                            $name,
                            ['class' => 'custom-control-label']
                        )
                    !!}
                </div>
            @endforeach
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
