<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!!
                Form::label(
                    'name',
                    __('admin.surveys.form.name')
                )
            !!}
            {!!
                Form::text(
                    'name',
                    old('name'),
                    [
                        'class' => 'form-control',
                        'id' => 'name',
                        'value' => isset($survey->name),
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
                    'description',
                    __('admin.surveys.form.description')
                )
            !!}
            {!!
                Form::text(
                    'description',
                    old('description'),
                    [
                        'class' => 'form-control',
                        'id' => 'description',
                        'value' => isset($survey->description),
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
                'questionnaire_id',
                __('admin.surveys.form.questionnaires')
            )
        !!}

        {!!
            Form::select(
                'questionnaire_id[]',
                $questionnaires->pluck('name', 'id'),
                old('questionnaire_id'),
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
