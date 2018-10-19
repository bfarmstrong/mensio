<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'name',
                    __('admin.groups.form.name')
                )
            !!}
            {!!
                Form::text(
                    'name',
                    old('name'),
                    [
                        'class' => 'form-control',
                        'id' => 'name',
                        'value' => isset($group->name),
                    ]
                )
            !!}

        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'therapist_id',
                __('admin.groups.form.therapists')
            )
        !!}
	@if(isset($users_id) && (!empty($users_id) || $users_id != ''))
		@php $users_id = $users_id; @endphp 
	@else
		@php $users_id = old('therapist_id'); @endphp 
	@endif
        {!!
            Form::select(
                'therapist_id[]',
                $therapists->pluck('name', 'id'),
                $users_id,
                ['class' => 'form-control selectpicker','multiple'=>'multiple']
            )
        !!}
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group mb-0">
            {!!
                Form::submit(
                    __('admin.groups.form.save'),
                    ['class' => 'btn btn-primary']
                )
            !!}
        </div>
    </div>
</div>
