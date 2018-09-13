<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>@lang('admin.users.table.email')</th>
            <th>@lang('admin.users.table.actions')</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            @if ($user->id !== Auth::id())
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ url("admin/users/$user->id/edit") }}"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            @lang('admin.users.table.edit')
                        </a>

                        {!!
                            Form::open([
                                'class' => 'd-inline-block',
                                'method' => 'delete',
                                'url' => url("admin/users/$user->id"),
                            ])
                        !!}
                        @include('admin.users.form-delete')
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
