<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.surveys.table.name')</th>
            <th>@lang('admin.surveys.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($surveys as $survey)
            <tr>
                <td>{{ $survey->name }}</td>
                <td>

                    @if (Auth::user()->isAdmin())
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("admin/surveys/$survey->id/edit") }}"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            @lang('admin.surveys.table.edit')
                        </a>

                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'onsubmit' => 'return confirm(\'' . __('admin.surveys.form-delete.on-submit') . '\')',
                                'url' => url("admin/surveys/$survey->id"),
                            ])
                        !!}
                        @include('admin.surveys.form-delete')
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
