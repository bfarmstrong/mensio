<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.roles.table.name')</th>
            <th>@lang('admin.roles.table.label')</th>
            <th>@lang('admin.roles.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->label }}</td>
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/roles/$role->uuid/edit") }}"
                    >
                        <i class="fas fa-edit mr-1"></i>
                        @lang('admin.roles.table.edit')
                    </a>

                    @unless ($role->protected)
                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'onsubmit' => 'return confirm(\'' . __('admin.roles.form-delete.on-submit') . '\')',
                                'url' => url("admin/roles/$role->uuid"),
                            ])
                        !!}
                        @include('admin.roles.form-delete')
                        {!! Form::close() !!}
                    @endunless
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
