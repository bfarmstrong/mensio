<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('clients.questionnaires.table.status')</th>
            <th>@lang('clients.questionnaires.table.client')</th>
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
                <td>{{ $response->user->name }}</td>
                <td>{{ $response->questionnaire->name }}</td>
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url('clients/' . $response->user->id . '/questionnaires/' . $response->uuid) }}"
                    >
                        <i class="fas fa-search mr-1"></i>
                        @lang('clients.questionnaires.table.view')
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
