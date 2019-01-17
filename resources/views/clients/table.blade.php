<table class="client-datatable table table-hover table-outline table-striped dt-responsive nowrap w-100">
    <thead class="thead-light">
        <tr>
            <th>@lang('clients.table.name')</th>
            <th>@lang('clients.table.email')</th>
            <th>@lang('clients.table.insurance')</th>
            <th>@lang('clients.table.actions')</th>
        </tr>
    </thead>
</table>

<div class="d-none" id="user-actions-template">
    <div class="btn-group">
        <a
            class="btn btn-primary btn-sm"
            href="{{ url('clients/USER_ID') }}"
        >
            <i class="fas fa-search mr-1"></i>
            @lang('clients.table.view')
        </a>

        <button
            aria-expanded="false"
            aria-haspopup="true"
            class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
            data-toggle="dropdown"
            type="button"
        >
            <span class="sr-only">
                @lang('clients.table.toggle-dropdown')
            </span>
        </button>

        <div class="dropdown-menu">
            <a
                class="dropdown-item"
                href="{{ url('clients/USER_ID/notes') }}"
            >
                <i class="fas fa-sticky-note mr-1"></i>
                @lang('clients.table.notes')
            </a>
            
            <a
                class="dropdown-item"
                href="{{ url("clients/USER_ID/surveys") }}"
            >
                @lang('clients.table.surveys')
            </a>
            
            <a
                class="dropdown-item"
                href="{{ url('clients/USER_ID/questionnaires') }}"
            >
                <i class="fas fa-question mr-1"></i>
                @lang('clients.table.questionnaires')
            </a>
			
			<a
                class="dropdown-item"
                href="{{ url("clients/USER_ID/charts") }}"
            >
                    <i class="fas fa-chart-bar mr-1"></i>
                    @lang('clients.table.charts')
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    window.$('.client-datatable').DataTable({
        ajax: '/clients',
        processing: true,
        serverSide: true,
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'health_card_number' },
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
