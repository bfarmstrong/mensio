<table class="{{ $type }}-datatable table table-hover table-outline table-striped dt-responsive nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.users.table.name')</th>
            <th>@lang('admin.users.table.email')</th>
            <th>@lang('admin.users.table.role')</th>
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
                    @lang('admin.users.table.edit')
                </a>
            @endif

            @if (Auth::user()->isSuperAdmin())
                {!!
                    Form::open([
                        'class' => 'd-inline-block w-100',
                        'method' => 'delete',
                        'onsubmit' => 'return confirm(\'' . __('admin.users.form-delete.on-submit') . '\')',
                        'url' => url("admin/users/USER_ID"),
                    ])
                !!}
                @include('admin.users.form-delete')
                {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    window.$('.{{ $type }}-datatable').DataTable({
        ajax: {
            dataSrc: '',
            url: '/admin/users?type={{ $type }}',
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'role.name' },
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
</script>
@endpush
