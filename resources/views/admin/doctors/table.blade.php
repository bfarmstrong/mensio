<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.doctors.table.name')</th>
            <th>@lang('admin.doctors.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($doctors as $doctor)
            <tr>
                <td>{{ $doctor->name }}</td>
                <td>
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/doctors/$doctor->uuid/edit") }}"
                    >
                        <i class="fas fa-edit mr-1"></i>
                        @lang('admin.doctors.table.edit')
                    </a>

                    {!!
                        Form::open([
                            'class' => 'd-inline-block',
                            'method' => 'delete',
                            'onsubmit' => 'return confirm(\'' . __('admin.doctors.form-delete.on-submit') . '\')',
                            'url' => url("admin/doctors/$doctor->uuid"),
                        ])
                    !!}
                    @include('admin.doctors.form-delete')
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
