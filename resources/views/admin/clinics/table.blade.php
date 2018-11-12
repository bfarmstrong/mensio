<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.clinics.table.name')</th>
            <th>@lang('admin.clinics.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($clinics as $clinic)
            <tr>
                <td>{{ $clinic->name }}</td>
                <td>
                    <div class="btn-group">
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("admin/clinics/$clinic->uuid/assignclinic") }}"
                        >
                            <i class="fas fa-user mr-1"></i>
                            @lang('admin.clinics.table.users')
                        </a>

                        <button
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"
                            type="button"
                        >
                            <span class="sr-only">
                                @lang('admin.clinics.table.toggle-dropdown')
                            </span>
                        </button>

                        <div class="dropdown-menu">
                            @if (Auth::user()->isSuperAdmin())
                                <a
                                    class="dropdown-item"
                                    href="{{ url("admin/clinics/$clinic->uuid/edit") }}"
                                >
                                    <i class="fas fa-edit mr-1"></i>
                                    @lang('admin.clinics.table.edit')
                                </a>
                            @endif

                            @if (Auth::user()->isSuperAdmin())
                                {!!
                                    Form::open([
                                        'class' => 'd-inline-block w-100',
                                        'method' => 'delete',
                                        'onsubmit' => 'return confirm(\'' . __('admin.clinics.form-delete.on-submit') . '\')',
                                        'url' => url("admin/clinics/$clinic->uuid"),
                                    ])
                                !!}
                                @include('admin.clinics.form-delete')
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
