<table class="table table-hover table-outline table-striped mb-0">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.therapists.table.name')</th>
            <th>@lang('admin.users.therapists.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($therapists as $therapist)
            <tr>
                <td>{{ $therapist->name }}</td>
                <td>
                    {!!
                        Form::open([
                            'class' => 'd-inline-block',
                            'method' => 'delete',
                            'onsubmit' => 'return confirm(\'' . __('admin.users.therapists.form-delete.on-submit') . '\')',
                            'url' => url("admin/users/$user->id/therapists/$therapist->id"),
                        ])
                    !!}
                    @include('admin.users.therapists.form-delete')
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
