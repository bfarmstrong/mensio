<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.clinics.table.name')</th>
            <th>@lang('admin.clinics.table.email')</th>
            <th>@lang('admin.clinics.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>

                    {!!
                        Form::open([
                            'class' => 'd-inline-block',
                            'method' => 'delete',
                            'onsubmit' => 'return confirm(\'' . __('admin.clinics.assignclinic.on-submit') . '\')',
                            'url' => url("admin/clinics/$user->id/assignclinic"),
                        ])
                    !!}
                    @include('admin.clinics.assignclinics.form-delete')
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
