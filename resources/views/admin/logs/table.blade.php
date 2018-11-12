<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.logs.table.causer-type')</th>
            <th>@lang('admin.logs.table.causer-id')</th>
            <th>@lang('admin.logs.table.action')</th>
            <th>@lang('admin.logs.table.subject-type')</th>
            <th>@lang('admin.logs.table.subject-id')</th>
            <th>@lang('admin.logs.table.timestamp')</th>
            <th>@lang('admin.logs.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->causer_type ?? 'N/A' }}</td>
                <td>{{ $log->causer->uuid ?? $log->causer->id ?? 'N/A' }}</td>
                <td>{{ $log->description ?? 'N/A' }}</td>
                <td>{{ $log->subject_type ?? 'N/A' }}</td>
                <td>{{ $log->subject->uuid ?? $log->subject->id ?? 'N/A' }}</td>
                <td>{{ $log->created_at }}</td>
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url('admin/logs', $log->id) }}"
                    >
                        <i class="fas fa-search mr-1"></i>
                        @lang('admin.logs.table.view')
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
