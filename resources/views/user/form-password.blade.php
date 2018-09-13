<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'old_password',
                    __('user.form-password.old-password')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-asterisk"></i>
                    </div>
                </div>

                {!!
                    Form::password(
                        'old_password',
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'new_password',
                    __('user.form-password.new-password')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-asterisk"></i>
                    </div>
                </div>

                {!!
                    Form::password(
                        'new_password',
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'new_password_confirmation',
                    __('user.form-password.confirm-password')
                )
            !!}

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-asterisk"></i>
                    </div>
                </div>

                {!!
                    Form::password(
                        'new_password_confirmation',
                        ['class' => 'form-control']
                    )
                !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('user.form-password.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}
        </div>
    </div>
</div>
