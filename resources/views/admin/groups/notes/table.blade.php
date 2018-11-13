<table class="table table-hover table-outline table-striped">
        <thead class="thead-light">
            <tr>
                <th>@lang('groups.notes.table.creator')</th>
                <th>@lang('groups.notes.table.date')</th>
                <th>@lang('groups.notes.table.status')</th>
                <th>@lang('groups.notes.table.actions')</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notes as $note)
                <tr>
                    <td>{{ $note->therapist->name }}</td>
                    <td>{{ $note->updated_at }}</td>
                    <td>
                        @if ($note->is_draft)
                            @lang('groups.notes.table.draft')
                        @else
                            @lang('groups.notes.table.final')
                        @endif
                    </td>
                    <td>
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("groups/$group->uuid/notes/$note->uuid") }}"
                        >
                            <i class="fas fa-search mr-1"></i>
                            @lang('groups.notes.table.view')
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
