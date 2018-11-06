<table class="datatable table table-hover table-outline table-striped dt-responsive nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th>@lang('clients.table.name')</th>
            <th>@lang('clients.table.email')</th>
            <th>@lang('clients.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <div class="btn-group">
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("clients/$user->id") }}"
                        >
                            <i class="fas fa-search mr-1"></i>
                            @lang('clients.table.view')
                        </a>

                        <button
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"
                            type="button"
                        >
                            <span class="sr-only">
                                @lang('clients.table.toggle-dropdown')
                            </span>
                        </button>

                        <div class="dropdown-menu">
                            <a
                                class="dropdown-item"
                                href="{{ url("clients/$user->id/notes") }}"
                            >
                                @lang('clients.table.notes')
                            </a>

                            <a
                                class="dropdown-item"
                                href="{{ url("clients/$user->id/questionnaires") }}"
                            >
                                @lang('clients.table.questionnaires')
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
