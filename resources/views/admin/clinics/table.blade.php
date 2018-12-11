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
					@if (Auth::user()->isSuperAdmin())
						<a
							class="btn btn-primary btn-sm"
							href="{{ url("admin/clinics/$clinic->uuid/edit") }}"
						>
							<i class="fas fa-edit mr-1"></i>
							@lang('admin.clinics.table.edit')
						</a>
					@endif
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url("admin/clinics/$clinic->id/assignclinic") }}"
                    >
                       
                        @lang('admin.clinics.assignclinic.assign')
                    </a>
					@if (Auth::user()->isSuperAdmin())
						{!!
							Form::open([
								'class' => 'd-inline-block',
								'method' => 'delete',
								'onsubmit' => 'return confirm(\'' . __('admin.clinics.form-delete.on-submit') . '\')',
								'url' => url("admin/clinics/$clinic->uuid"),
							])
						!!}
						@include('admin.clinics.form-delete')
						{!! Form::close() !!}
					@endif
                </td>
            </tr>
		@endif
        @endforeach
    </tbody>
</table>