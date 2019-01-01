<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.clinics.table.name')</th>
            <th>@lang('admin.clinics.table.actions')</th>
        </tr>
    </thead>

    <tbody>
	@php 
		$unique_clinic=[];
	@endphp
	
	
        @foreach($clinics as $clinic)
		@if(!in_array($clinic->name,$unique_clinic))
		@php array_push($unique_clinic,$clinic->name); @endphp
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

                        @if (Auth::user()->isSuperAdmin())
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
                                <a
                                    class="dropdown-item"
                                    href="{{ url("admin/clinics/$clinic->uuid/edit") }}"
                                >
                                    <i class="fas fa-edit mr-1"></i>
                                    @lang('admin.clinics.table.edit')
                                </a>

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
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
		@endif
        @endforeach
    </tbody>
</table>