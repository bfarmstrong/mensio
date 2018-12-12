<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('clients.surveys.table.name')</th>
            <th>@lang('clients.surveys.table.description')</th>
            <th>@lang('clients.surveys.table.questionnaire')</th>
            <th>@lang('clients.surveys.table.link')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($surveys as $survey)
            <tr>
                <td>{{ $survey->name }}</td>
				<td>{{ $survey->description }}</td>
				@php
					$final_questionnaire = '';
					$questionnaires = $survey->questionnaires()->pluck('questionnaires.name');
					foreach($questionnaires as $questionnaire){
						$final_questionnaire .= ','.$questionnaire;
					}
					
				@endphp
				<td> {{ $final_questionnaire }}</td>
				<td><a href="{{ url('/') }}/multipleresponse/{{ $survey->uuid }}">{{ url('/') }}/multipleresponse/{{ $survey->uuid }}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
