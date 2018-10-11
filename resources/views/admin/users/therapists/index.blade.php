@extends('layout.dashboard')

@section('title', __('admin.users.therapists.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.therapists.index', $user))
@section('content.dashboard')
    @unless ($user->therapists->isEmpty())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.users.therapists.index.current-therapists')
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @include('admin.users.therapists.table', [
                            'supervisors' => $supervisors,
                            'therapists' => $user->therapists,
                            'user' => $user,
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endunless

    @unless ($therapists->isEmpty())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus mr-1"></i>
                @lang('admin.users.therapists.index.add-therapist')
            </div>

            <div class="card-body">
                {!!
                    Form::open([
                        'method' => 'post',
                        'url' => url("admin/users/$user->id/therapists"),
                    ])
                !!}
                @include('admin.users.therapists.form-add', [
                    'therapists' => $therapists,
                ])
                {!! Form::close() !!}
            </div>
        </div>
    @endunless
@endsection
