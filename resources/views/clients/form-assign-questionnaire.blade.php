<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'questionnaire_id',
                __('clients.form-assign-questionnaire.questionnaire')
            )
        !!}

        {!!
            Form::select(
                'questionnaire_id',
                $questionnaires->pluck('name', 'id'),
                old('questionnaire_id'),
                ['class' => 'form-control']
            )
        !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 mb-0">
        {!!
            Form::submit(
                __('clients.form-assign-questionnaire.assign'),
                ['class' => 'btn btn-primary']
            )
        !!}
    </div>
</div>
