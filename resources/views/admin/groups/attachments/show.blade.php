@extends('layout.dashboard')

@php
    $download = "/groups/$group->uuid/attachments/$attachment->uuid/download";
@endphp

@section('title', __('clients.attachments.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('groups.attachments.show', $group, $attachment))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-paperclip mr-1"></i>
                @lang('clients.attachments.show.attachment')
            </span>
        </div>

        <div class="card-body">
            @if (starts_with($attachment->mime_type, 'image/'))
                <img
                    class="img-fluid mx-auto d-block"
                    src="{{ $download }}"
                />
            @elseif ($attachment->mime_type === 'text/plain')
                @php
                    $contents = \Storage::disk(config('filesystems.cloud'))->get($attachment->file_location);
                @endphp

                <pre>{{ $contents }}</pre>
            @endif

            @if ($attachment->isSignatureValid($attachment->therapist_id))
                <i class="fas fa-lock text-success float-right"></i>
            @else
                <i
                    class="fas fa-exclamation-triangle text-danger float-right"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{ __('clients.attachments.show.signature-invalid') }}"
                >
                </i>
            @endif
        </div>
    </div>
@endsection
