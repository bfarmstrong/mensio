@extends('layout.dashboard')

@section('title', __('admin.users.groups.index.title'))
@section('content.breadcrumbs', Breadcrumbs::render('admin.users.therapists.index', $user))
@section('content.dashboard')
    @unless ($user->groups->isEmpty())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.users.groups.index.current-groups')
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @if ($groups->isNotEmpty())
							@include('admin.users.groups.table', ['groups' => $groups])
						@endif
                    </div>
                </div>
            </div>
        </div>
    @endunless

    @unless ($all_groups->isEmpty())
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus mr-1"></i>
                @lang('admin.users.groups.index.add-group')
            </div>

            <div class="card-body">
                {!!
                    Form::open([
                        'method' => 'post',
                        'url' => url("admin/users/$user->id/groups"),
                    ])
                !!}
                @include('admin.users.groups.form-add', [
                    'all_groups' => $all_groups,
                ])
                {!! Form::close() !!}
            </div>
        </div>
    @endunless
@endsection
