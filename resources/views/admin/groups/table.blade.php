<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.groups.table.name')</th>
            <th>@lang('admin.groups.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
              
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/groups/$group->id/edit") }}"
                    >
                        <i class="fas fa-edit mr-1"></i>
                        @lang('admin.groups.table.edit')
                    </a>

                    @unless ($group->protected)
                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'onsubmit' => 'return confirm(\'' . __('admin.groups.form-delete.on-submit') . '\')',
                                'url' => url("admin/groups/$group->id"),
                            ])
                        !!}
                        @include('admin.groups.form-delete')
                        {!! Form::close() !!}
                    @endunless
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
