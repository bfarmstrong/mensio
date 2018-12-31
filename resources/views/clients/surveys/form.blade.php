<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'survey_id',
                __('clients.questionnaires.form-assign.questionnaire')
            )
        !!}

        {!!
            Form::select(
                'survey_id',
				$all_surveys,
                old('survey_id'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('clients.questionnaires.form-assign.assign'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
