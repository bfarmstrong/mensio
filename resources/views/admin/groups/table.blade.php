<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.groups.table.name')</th>
            <th>@lang('admin.groups.table.members')</th>
            <th>@lang('admin.groups.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>
                    <table class="table table-hover table-outline table-sm table-striped mb-0">
                        <tbody>
                            @foreach ($group->users as $user)
                                @if ($user->isClient())
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    @if (Auth::user()->isTherapist())
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("groups/$group->uuid/notes") }}"
                        >
                            <i class="fas fa-sticky-note mr-1"></i>
                            @lang('groups.show.notes')
                        </a>

                        <a
                            class="btn btn-primary btn-sm ml-auto"
                            href="{{ url("groups/$group->uuid/questionnaires/create") }}"
                        >
                            <i class="fas fa-question mr-1"></i>
                            @lang('groups.questionnaires.index.assign')
                        </a>
                    @endif

                    @if (Auth::user()->isAdmin())
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("admin/groups/$group->uuid/edit") }}"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            @lang('admin.groups.table.edit')
                        </a>

                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'onsubmit' => 'return confirm(\'' . __('admin.groups.form-delete.on-submit') . '\')',
                                'url' => url("admin/groups/$group->uuid"),
                            ])
                        !!}
                        @include('admin.groups.form-delete')
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
