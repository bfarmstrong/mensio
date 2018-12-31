@extends('layout.dashboard')

@section('title', __('admin.users.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.users.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.users.index.users')
            </span>

			<div class="ml-auto">
                <div class="btn-group">
                    <a
                        class="btn btn-primary btn-sm"
                        href="{{ url('admin/users/invite') }}"
                    >
                        <i class="fas fa-user-plus mr-1"></i>
                        @lang('admin.users.index.create-user')
                    </a>

                    @isset($currentClinic)
                        <button
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown"
                            type="button"
                        >
                            <span class="sr-only">
                                @lang('admin.users.index.toggle-dropdown')
                            </span>
                        </button>

                        <div class="dropdown-menu">
                            <a
                                class="dropdown-item"
                                href="{{ url('admin/users/add') }}"
                            >
                                @lang('admin.users.index.assign-clinic')
                            </a>
                        </div>
                    @endisset
                </div>
            </div>
		</div>

        <div class="card-body">
            @if ($clients->isNotEmpty() && $therapists->isNotEmpty())
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    data-toggle="tab"
                                    href="#clients"
                                >
                                    @lang('admin.users.index.clients')
                                </a>
                            </li>

                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    data-toggle="tab"
                                    href="#therapists"
                                >
                                    @lang('admin.users.index.therapists')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    @if ($users->isNotEmpty())
                        @if ($clients->isNotEmpty() && $therapists->isNotEmpty())
                            <div class="tab-content">
                        @endif
                        @if ($clients->isNotEmpty())
                            @if ($therapists->isNotEmpty())
                                <div id="clients" class="tab-pane active">
                            @endif
                            @include('admin.users.table', [
                                'insurance' => true,
                                'type' => 'clients',
                            ])
                            @if ($therapists->isNotEmpty())
                                </div>
                            @endif
                        @endif

                        @if ($therapists->isNotEmpty())
                            @if ($clients->isNotEmpty())
                                <div id="therapists" class="tab-pane">
                            @endif
                            @include('admin.users.table', [
                                'type' => 'therapists',
                            ])
                            @if ($clients->isNotEmpty())
                                </div>
                            @endif
                        @endif
                        @if ($clients->isNotEmpty() && $therapists->isNotEmpty())
                            </div>
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
