@extends('layout.dashboard')

@section('title', __('groups.notes.show.title'))
@section('content.breadcrumbs', Breadcrumbs::render('groups.notes.show', $group, $note))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sticky-note mr-1"></i>
            @lang('groups.notes.show.form-title')
        </div>

        <div class="card-body">
            @if ($note->is_draft)
                {!!
                    Form::open([
                        'method' => 'put',
                        'url' => "groups/$group->uuid/notes/$note->uuid",
                    ])
                !!}

            @endif
            @include('admin.groups.notes.form', [
                'group' => $group,
                'note' => $note,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
