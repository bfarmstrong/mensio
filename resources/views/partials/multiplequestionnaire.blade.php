@php $id = str_random(24);   @endphp

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
			@if ($answerss)
                data: @json(json_decode($answerss)),
            @endif
            @unless (Auth::user()->isClient())
                mode: 'display',
            @endunless
            model: survey,
			onCurrentPageChanging : function(sender, options) { 
		
				dataput[response[i]] = JSON.stringify(sender.data);
				i = i+1;
				
			},

			onComplete: function(sender, options) {
				var obj = JSON.parse(JSON.stringify(sender.data));
				var lastobj = Object.keys(obj);
				var last_key =lastobj[lastobj.length-1];
				dataput[response[i]] = '{"'+last_key+'":'+JSON.stringify(obj[last_key])+'}';
				dataInput.val(JSON.stringify(dataput));			
			   	dataForm.submit();
            },
            showCompletedPage: false,
			showNavigationButtons: true,
        });

    </script>
@endpush
