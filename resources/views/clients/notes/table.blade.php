@php
    ($finals->isNotEmpty() && $active = 'finals') ||
        ($drafts->isNotEmpty() && $active = 'drafts') ||
        ($attachments->isNotEmpty() && $active = 'attachments') ||
        ($communication->isNotEmpty() && $active = 'communication') ||
        ($receipts->isNotEmpty() && $active = 'receipts');

    (Request::query('drafts_page') && $active = 'drafts') ||
        (Request::query('attachments_page') && $active = 'attachments') ||
        (Request::query('communication_page') && $active = 'communication') ||
        (Request::query('receipts_page') && $active = 'receipts');
@endphp

<ul class="nav nav-tabs">
    @if ($finals->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link {{ $active === 'finals' ? 'active' : '' }}"
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
                class="nav-link {{ $active === 'drafts' ? 'active' : '' }}"
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
                class="nav-link {{ $active === 'attachments' ? 'active' : '' }}"
                data-toggle="tab"
                href="#attachments"
            >
                @lang('clients.notes.table.attachments')
            </a>
        </li>
    @endif

    @if ($communication->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link {{ $active === 'communication' ? 'active' : '' }}"
                data-toggle="tab"
                href="#communication"
            >
                @lang('clients.notes.table.communication-logs')
            </a>
        </li>
    @endif

    @if ($receipts->isNotEmpty())
        <li class="nav-item">
            <a
                class="nav-link {{ $active === 'receipts' ? 'active' : '' }}"
                data-toggle="tab"
                href="#receipts"
            >
                @lang('clients.notes.table.receipts')
            </a>
        </li>
    @endif
</ul>

<div class="tab-content">
    @if ($finals->isNotEmpty())
        <div id="final-notes" class="tab-pane {{ $active === 'finals' ? 'active' : 'fade' }}">
            <table class="table table-hover table-outline table-striped w-100 nowrap">
                <thead class="thead-light">
                    <tr>
                        <th>@lang('clients.notes.table.creator')</th>
                        @isset ($group)
                            <th>@lang('clients.notes.table.client')</th>
                        @endisset
                        <th>@lang('clients.notes.table.date')</th>
                        <th>@lang('clients.notes.table.status')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($finals as $note)
                        <tr>
                            <td>{{ $note->therapist->name }}</td>
                            @isset ($group)
                                <td>{{ $note->client->name }}</td>
                            @endisset
                            <td>{{ $note->updated_at }}</td>
                            <td>@lang('clients.notes.table.final')</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("$prefix/notes/$note->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $finals->appends('finals_page')->links() }}
        </div>
    @endif

    @if ($drafts->isNotEmpty())
        <div id="drafts" class="tab-pane {{ $active === 'drafts' ? 'active' : 'fade' }}">
            <table class="table table-hover table-outline table-striped w-100 nowrap">
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
                                    href="{{ url("$prefix/notes/$note->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $drafts->appends('drafts_page')->links() }}
        </div>
    @endif

    @if ($attachments->isNotEmpty())
        <div id="attachments" class="tab-pane {{ $active === 'attachments' ? 'active' : 'fade' }}">
            <table class="table table-hover table-outline table-striped w-100 nowrap">
                <thead class="thead-light">
                    <tr>
                        <th>@lang('clients.notes.table.name')</th>
                        @isset ($group)
                            <th>@lang('clients.notes.table.client')</th>
                        @endisset
                        <th>@lang('clients.notes.table.type')</th>
                        <th>@lang('clients.notes.table.date')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($attachments as $attachment)
                        <tr>
                            <td>{{ $attachment->file_name }}</td>
                            @isset ($group)
                                <td>{{ $attachment->user->name }}</td>
                            @endisset
                            <td>{{ $attachment->mime_type }}</td>
                            <td>{{ $attachment->updated_at }}</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("$prefix/attachments/$attachment->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $attachments->appends('attachments_page')->links() }}
        </div>
    @endif

    @if ($communication->isNotEmpty())
        <div id="communication" class="tab-pane {{ $active === 'communication' ? 'active' : 'fade' }}">
            <table class="table table-hover table-outline table-striped w-100 nowrap">
                <thead class="thead-light">
                    <tr>
                        @isset ($group)
                            <th>@lang('clients.notes.table.client')</th>
                        @endisset
                        <th>@lang('clients.notes.table.appointment-date')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($communication as $log)
                        <tr>
                            @isset ($group)
                                <td>{{ $log->user->name }}</td>
                            @endisset
                            <td>{{ $log->appointment_date }}</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("$prefix/communication/$log->uuid") }}"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $communication->appends('communication_page')->links() }}
        </div>
    @endif

    @if ($receipts->isNotEmpty())
        <div id="receipts" class="tab-pane {{ $active === 'receipts' ? 'active' : 'fade' }}">
            <table class="table table-hover table-outline table-striped w-100 nowrap">
                <thead class="thead-light">
                    <tr>
                        @isset ($group)
                            <th>@lang('clients.notes.table.client')</th>
                        @endisset
                        <th>@lang('clients.notes.table.appointment-date')</th>
                        <th>@lang('clients.notes.table.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            @isset ($group)
                                <td>{{ $receipt->user->name }}</td>
                            @endisset
                            <td>{{ $receipt->appointment_date }}</td>
                            <td>
                                <a
                                    class="btn btn-primary btn-sm"
                                    href="{{ url("$prefix/receipts/$receipt->uuid/download") }}"
                                    target="_blank"
                                >
                                    <i class="fas fa-search mr-1"></i>
                                    @lang('clients.notes.table.view')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $receipts->appends('receipts_page')->links() }}
        </div>
    @endif
</div>
