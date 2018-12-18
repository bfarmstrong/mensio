@php $id = str_random(24);  @endphp

<div
    class="questionnaire-container"
    id="questionnaire-{{ $id }}"
>
</div>
@isset ($response)
        {!!
            Form::open([
                'id' => "form-$id",
                'method' => 'patch',
                'url' => URL::signedRoute('responses.update-data-survey', [
                    'survey_id' => Request::segment(2),
                ]),
            ])
        !!}
		{!! Form::hidden('data', null) !!}
        {!! Form::close() !!}
   
@endisset


@push('scripts') 
    <script type="text/javascript">
        var questionnaire = @json(json_decode($questionnaire));
        var survey = new window.Survey.Model(questionnaire);
        var dataForm = window.$('#form-{{ $id }}');
        var dataInput = window.$('#form-{{ $id }} input[name="data"]');
		var dataput = [];
		
        window.Survey.StylesManager.applyTheme('bootstrap');
        window.$('#questionnaire-{{ $id }}').Survey({

            @unless (Auth::user()->isClient())
                mode: 'display',
            @endunless
            model: survey,
			onCurrentPageChanging : function(sender, options) { 
				dataput.push(JSON.stringify(sender.data));
			},
            onComplete: function(sender, options) {
				dataInput.val(JSON.stringify(dataput));
				
             	dataForm.submit();
            },
            showCompletedPage: false,
			//showProgressBar : 'bottom',
			//goNextPageAutomatic: true,
			showNavigationButtons: true,
        });
    </script>
@endpush
