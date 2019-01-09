<table class="table table-hover table-outline table-striped">
    <thead class="thead-light">
        <tr>
            <th>@lang('admin.documents.table.name')</th>
        </tr>
    </thead>

    <tbody>
        @foreach($documents as $document)
            <tr>
                <td>{{ $document->name }}</td>
              
            </tr>
        @endforeach
    </tbody>
</table>
