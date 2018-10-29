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
						href="{{ url("groups/$group->id/notes") }}"
					> <i class="fas fa-sticky-note mr-1"></i>
						@lang('groups.show.notes')
					</a>
					
					<a
						class="btn btn-primary btn-sm ml-auto"
						href="{{ url("groups/$group->id/questionnaires/create") }}"
					>
						@lang('groups.questionnaires.index.assign')
					</a>						
				@if (Auth::user()->isAdmin())

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

				@endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
