@extends('layout.dashboard')

@section('title', __('clients.notes.show.title'))

@section('content.breadcrumbs', Breadcrumbs::render('clients.notes.show', $user, $note))
@section('content.dashboard')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-sticky-note mr-1"></i>
            @lang('clients.notes.show.form-title')
        </div>

        <div class="card-body">
            @if ($note->is_draft)
                {!!
                    Form::open([
                        'method' => 'put',
                        'url' => "clients/$user->id/notes/$note->uuid",
                    ])
                !!}
            @else
                {!!
                    Form::open([
                        'method' => 'post',
                        'url' => "clients/$user->id/notes/$note->uuid/addition",
                    ])
                !!}
            @endif
            @include('clients.notes.form', [
                'client' => $user,
                'note' => $note,
                'therapist' => $note->therapist,
            ])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
