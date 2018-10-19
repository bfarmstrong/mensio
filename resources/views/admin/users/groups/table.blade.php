<table class="table table-hover table-outline table-striped mb-0">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.groups.table.name')</th>
            <th>@lang('admin.users.groups.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>
                    {{ $group->name }}
                </td>

                <td>
                    {!!
                        Form::open([
                            'class' => 'd-inline-block',
                            'method' => 'delete',
                            'onsubmit' => 'return confirm(\'' . __('admin.users.groups.form-delete.on-submit') . '\')',
                            'url' => url("admin/users/$user->id/groups/$group->id"),
                        ])
                    !!}
                    @include('admin.users.groups.form-delete')
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
