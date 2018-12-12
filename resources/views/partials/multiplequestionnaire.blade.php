@php $id = str_random(24); @endphp
<h2>{{ $response->name }}</h2>
<div
    class="questionnaire-container"
    id="questionnaire-{{ $id }}"
>
</div>

@isset ($response)
    @can ('submit', $response)
        {!!
            Form::open([
                'id' => "form-$id",
                'method' => 'patch',
                'url' => URL::signedRoute('responses.update-data', [
                    'response_id' => $response->uuid,
                ]),
            ])
        !!}
        {!! Form::hidden('data', null) !!}
        {!! Form::close() !!}
    @endcan
@endisset

@push('scripts')
    <script type="text/javascript">
        var questionnaire = @json(json_decode($questionnaire->data));
        var survey = new window.Survey.Model(questionnaire);
        var dataForm = window.$('#form-{{ $id }}');
        var dataInput = window.$('#form-{{ $id }} input[name="data"]');

        window.Survey.StylesManager.applyTheme('bootstrap');
        window.$('#questionnaire-{{ $id }}').Survey({
            @if ($response->data)
                data: @json(json_decode($response->data)),
            @endif
            @unless (Auth::user()->isClient())
                mode: 'display',
            @endunless
            model: survey,
            onComplete: function(sender, options) {
                dataInput.val(JSON.stringify(sender.data));
                dataForm.submit();
            },
            showCompletedPage: false,
        });
    </script>
@endpush
