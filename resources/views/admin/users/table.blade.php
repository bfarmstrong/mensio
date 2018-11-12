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
    <a
        class="btn btn-primary btn-sm"
        href="{{ url("admin/users/USER_ID") }}"
    >
        <i class="fas fa-search mr-1"></i>
        @lang('admin.users.table.view')
    </a>

    @if(Auth::user()->isAdmin())
        <a
            class="btn btn-primary btn-sm"
            href="{{ url("admin/users/USER_ID/edit") }}"
        >
            <i class="fas fa-edit mr-1"></i>
            @lang('admin.users.table.edit')
        </a>
    @endif

    @if (!Session::get('original_user'))
        <a
            class="btn btn-primary btn-sm"
            href="{{ url("admin/users/switch/USER_ID") }}"
        >
            <i class="fas fa-user mr-1"></i>
            @lang('user.form-settings.switch-user')
        </a>
    @endif

    @if (Auth::user()->isSuperadmin())
        {!!
            Form::open([
                'class' => 'd-inline-block',
                'method' => 'delete',
                'onsubmit' => 'return confirm(\'' . __('admin.users.form-delete.on-submit') . '\')',
                'url' => url("admin/users/USER_ID"),
            ])
        !!}
        @include('admin.users.form-delete')
        {!! Form::close() !!}
    @endif
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
                    template.children().each(function () {
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
