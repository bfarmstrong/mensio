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

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/users/invite') }}"
            >
                @lang('admin.users.index.create-user')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('admin/users/search')
                        ])
                    !!}
                    @include('admin.users.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($users->isNotEmpty())
                        @include('admin.users.table', ['users' => $users])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.users.index.no-results')
                        </p>
                    @endif

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
