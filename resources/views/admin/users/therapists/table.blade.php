<table class="table table-hover table-outline table-striped mb-0">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.therapists.table.name')</th>
            <th>@lang('admin.users.therapists.table.supervisor')</th>
            <th>@lang('admin.users.therapists.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($therapists as $therapist)
            <tr>
                <td>
                    @if (
                        $therapist->hasRole(\App\Enums\Roles::JuniorTherapist) &&
                        $therapist->supervisors->isEmpty()
                    )
                        <i
                            class="fas fa-exclamation-triangle mr-3"
                            data-placement="top"
                            data-toggle="tooltip"
                            title="{{ __('admin.users.therapists.table.supervisor-required') }}"
                        >
                        </i>
                    @endif

                    {{ $therapist->name }}
                </td>
                <td>
                    {!!
                        Form::open([
                            'method' => 'patch',
                            'url' => url("admin/users/$user->id/therapists/$therapist->id/supervisors"),
                        ])
                    !!}
                    @include('admin.users.therapists.form-supervisor', [
                        'supervisor' => $therapist->supervisors->first()->id ?? null,
                    ])
                    {!! Form::close() !!}
                </td>
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
