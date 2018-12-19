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
		{!! Form::hidden('response', null) !!}
        {!! Form::close() !!}
   
@endisset


@push('scripts') 
    <script type="text/javascript">
        var questionnaire = @json(json_decode($questionnaire));
        var survey = new window.Survey.Model(questionnaire);
        var dataForm = window.$('#form-{{ $id }}');
        var dataInput = window.$('#form-{{ $id }} input[name="data"]');
        var dataResponse = window.$('#form-{{ $id }} input[name="response"]');
		var dataput = {};
		var dataresp = {};
		var i = 0;
		var response = @json(json_decode($response));
		
        window.Survey.StylesManager.applyTheme('bootstrap');
        window.$('#questionnaire-{{ $id }}').Survey({

            @unless (Auth::user()->isClient())
                mode: 'display',
            @endunless
            model: survey,
			onCurrentPageChanging : function(sender, options) { 
			
				dataput[response[i]] = JSON.stringify(sender.data);
				//dataresp[i] = response[i];
				i = i+1;
				
			},

			onComplete: function(sender, options) {
				// var fina =  $([JSON.stringify(sender.data)]).not(dataput).get();
				//dataput[response[i]] = JSON.stringify(sender.data);
				dataInput.val(JSON.stringify(dataput));
				//dataresp[i] = response[i];	
				
				//dataInput.val(JSON.stringify(sender.data));				
				//dataResponse.val(JSON.stringify(dataresp));				
			   	dataForm.submit();
            },
            showCompletedPage: false,
			//showProgressBar : 'bottom',
			//goNextPageAutomatic: true,
			showNavigationButtons: true,
        });

    </script>
@endpush
