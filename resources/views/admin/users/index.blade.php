@extends('layout.dashboard')

@section('title', __('admin.users.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.users.index.users')
            </span>
			<div class="float-right">
            <a
                class="btn btn-primary btn-sm"
                href="{{ url('admin/users/add') }}"
            >
                @lang('admin.users.index.assign-clinic')
            </a>

            <a
                class="btn btn-primary btn-sm"
                href="{{ url('admin/users/invite') }}"
            >
                @lang('admin.users.index.create-user')
            </a>
        </div>
		</div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($users->isNotEmpty())
                        @if ($clients->isNotEmpty())
                            <p class="h4">
                                @lang('admin.users.index.clients')
                            </p>
                            @include('admin.users.table', ['users' => $clients])
                        @endif

                        @if ($therapists->isNotEmpty())
                            @if ($clients->isNotEmpty())
                                <hr class="mt-1">
                            @endif

                            <p class="h4">
                                @lang('admin.users.index.therapists')
                            </p>
                            @include('admin.users.table', ['users' => $therapists])
                        @endif
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.users.index.no-results')
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
