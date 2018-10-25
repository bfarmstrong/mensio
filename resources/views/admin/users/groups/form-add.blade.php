<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'group_id',
                __('admin.users.groups.form-add.name')
            )
        !!}

        {!!
            Form::select(
                'group_id',
                $all_groups->pluck('name', 'id'),
                old('group_id'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>
{{ Form::hidden('user_id',$user->id) }}
<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('admin.users.groups.form-add.save'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>