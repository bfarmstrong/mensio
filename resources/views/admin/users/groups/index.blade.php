@extends('layout.dashboard')

@section('title', __('admin.users.groups.index.title'))


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

    @unless ($groups->isEmpty())
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
               
                {!! Form::close() !!}
            </div>
        </div>
    @endunless
@endsection
