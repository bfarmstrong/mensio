<div class="form-row">
    <div class="form-group col-12">
        {!!
            Form::label(
                'questionnaire_id',
                __('groups.questionnaires.form-assign.questionnaire')
            )
        !!}

        {!!
            Form::select(
                'questionnaire_id',
                $questionnaires->pluck('name', 'id'),
                old('questionnaire_id'),
                ['class' => 'form-control selectpicker']
            )
        !!}
    </div>
</div>

<div class="form-row">

	<div class="form-group col-12 mb-0">
        <button
            class="btn btn-primary"
            name="is_submit"
            type="submit"
            value="0"
        >
            @lang('groups.questionnaires.form-assign.assign')
        </button>

        
            <button
                class="btn btn-danger"
                name="is_submit"
                type="submit"
                value="1"
            >
                @lang('groups.questionnaires.form-unassign.unassign')
            </button>
        
    </div>
</div>
