<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('clients.questionnaires.table.status')</th>
            <th>@lang('clients.questionnaires.table.name')</th>
            <th>@lang('clients.questionnaires.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($responses as $response)
            <tr>
                <td>
                    <i
                        class="fas mr-1 fa-{{ $response->complete ? 'check text-success' : 'times text-danger' }}"
                    >
                    </i>
                </td>
                <td>{{ $response->questionnaire->name }}</td>
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        @if (Auth::user()->isClient())
                            href="{{ url("responses/$response->uuid") }}"
                        @else
                            href="{{ url("clients/$user->id/questionnaires/$response->uuid") }}"
                        @endif
                    >
                        <i class="fas fa-search mr-1"></i>
                        @lang('clients.questionnaires.table.view')
                    </a>

                    @can('destroy', $response)
                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'onsubmit' => 'return confirm(\'' . __('clients.questionnaires.form-unassign.on-submit') . '\')',
                                'url' => url("clients/$user->id/questionnaires/$response->questionnaire_id"),
                            ])
                        !!}
                        @include('clients.questionnaires.form-unassign')
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
