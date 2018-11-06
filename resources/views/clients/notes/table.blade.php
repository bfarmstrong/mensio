@php
    $finals = $notes->where('is_draft', 0);
    $drafts = $notes->where('is_draft', 1);
@endphp

<ul class="nav nav-tabs">
    @if ($finals->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link active"
                data-toggle="tab"
                href="#final-notes"
            >
                @lang('clients.notes.table.notes')
            </a>
        </li>
    @endif

    @if ($drafts->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link"
                data-toggle="tab"
                href="#drafts"
            >
                @lang('clients.notes.table.drafts')
            </a>
        </li>
    @endif

    @if ($attachments->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link"
                data-toggle="tab"
                href="#attachments"
            >
                @lang('clients.notes.table.attachments')
            </a>
        </li>
    @endif
</ul>

<div class="tab-content">
    @if ($finals->isNotEmpty())
        <div id="final-notes" class="tab-pane active">
            <table class="table table-hover table-outline table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>@lang('clients.notes.table.creator')</th>
                        <th>@lang('clients.notes.table.date')</th>
                        <th>@lang('clients.notes.table.status')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($finals as $note)
                        <tr>
                            <td>{{ $note->therapist->name }}</td>
                            <td>{{ $note->updated_at }}</td>
                            <td>@lang('clients.notes.table.final')</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("clients/$user->id/notes/$note->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($drafts->isNotEmpty())
        <div id="drafts" class="tab-pane fade">
            <table class="table table-hover table-outline table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>@lang('clients.notes.table.creator')</th>
                        <th>@lang('clients.notes.table.date')</th>
                        <th>@lang('clients.notes.table.status')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($drafts as $note)
                        <tr>
                            <td>{{ $note->therapist->name }}</td>
                            <td>{{ $note->updated_at }}</td>
                            <td>@lang('clients.notes.table.draft')</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("clients/$user->id/notes/$note->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($attachments->isNotEmpty())
        <div id="attachments" class="tab-pane fade">
            <table class="table table-hover table-outline table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>@lang('clients.notes.table.name')</th>
                        <th>@lang('clients.notes.table.type')</th>
                        <th>@lang('clients.notes.table.date')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($attachments as $attachment)
                        <tr>
                            <td>{{ $attachment->file_name }}</td>
                            <td>{{ $attachment->mime_type }}</td>
                            <td>{{ $attachment->updated_at }}</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("clients/$user->id/attachments/$attachment->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
