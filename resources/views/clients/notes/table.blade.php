<table class="table table-hover table-outline table-striped">
        <thead class="thead-light">
            <tr>
                <th>@lang('clients.notes.table.creator')</th>
                <th>@lang('clients.notes.table.date')</th>
                <th>@lang('clients.notes.table.status')</th>
                <th>@lang('clients.notes.table.actions')</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->therapist->name }}</td>
                    <td>{{ $note->updated_at }}</td>
                    <td>
                        @if ($note->is_draft)
                            @lang('clients.notes.table.draft')
                        @else
                            @lang('clients.notes.table.final')
                        @endif
                    </td>
                    <td>
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("clients/$user->id/notes/$note->uuid") }}"
                        >
                            <i class="fas fa-search mr-1"></i>
                            @lang('clients.notes.table.view')
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
