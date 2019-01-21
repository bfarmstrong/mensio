<table class="{{ $type }}-datatable table table-hover table-outline table-striped dt-responsive nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.table.name')</th>
            <th>@lang('admin.users.table.email')</th>
            @isset ($insurance)
                <th>@lang('admin.users.table.insurance')</th>
            @endisset
            <th>@lang('admin.users.table.actions')</th>
        </tr>
    </thead>

    <tbody></tbody>
</table>

<div class="d-none" id="user-actions-template">
    <div class="btn-group">
        <a
            class="btn btn-primary btn-sm"
            href="{{ url("admin/users/USER_ID") }}"
        >
            <i class="fas fa-search mr-1"></i>
            @lang('admin.users.table.view')
        </a>

        <button
            aria-expanded="false"
            aria-haspopup="true"
            class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
            data-toggle="dropdown"
            type="button"
        >
            <span class="sr-only">
                @lang('admin.users.table.toggle-dropdown')
            </span>
        </button>

        <div class="dropdown-menu">
            @if(Auth::user()->isAdmin())
                <a
                    class="dropdown-item"
                    href="{{ url("admin/users/USER_ID/edit") }}"
                >
                    <i class="fas fa-edit mr-1"></i>
                    @lang('admin.users.table.edit')
                </a>
            @endif 
			@if ($type == 'clients')
                <a 
                    class="dropdown-item type"
                    href="{{ url("admin/users/USER_ID/therapists") }}"
                >
                    <i class="fas fa-user mr-1"></i>
                    @lang('admin.users.show.therapists')
                </a>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    window.$('.{{ $type }}-datatable').DataTable({
        ajax: '/admin/{{ $type ?? 'users' }}',
        processing: true,
        serverSide: true,
        columns: [
            { data: 'name' },
            { data: 'email' },
            @isset ($insurance)
                { data: 'health_card_number' },
            @endisset
            {
                data: 'id',
                render: function (data) {
                    var template = $('#user-actions-template').clone();
                    template.find('a,form').each(function () {
                        var element = $(this);
                        if (element.attr('href')) {
                            element.attr('href', element.attr('href').replace('USER_ID', data));
                        }
                        if (element.attr('url')) {
                            element.attr('url', element.attr('url').replace('USER_ID', data));
                        }
                    });

                    return template.html();
                }
            },
        ],
        deferRender: true,
        responsive: true,
    });
	$(window).on('load',function(){
		$('#therapists .type').hide();
	});
</script>
@endpush
