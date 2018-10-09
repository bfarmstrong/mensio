@extends('layout.dashboard')

@section('title', __('admin.roles.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.roles.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <i class="fas fa-list-ul mr-1"></i>
            @lang('admin.roles.index.roles')

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/roles/create') }}"
            >
                @lang('admin.roles.index.create-role')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('admin/roles/search')
                        ])
                    !!}
                    @include('admin.roles.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($roles->isNotEmpty())
                        @include('admin.roles.table', ['roles' => $roles])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.roles.index.no-results')
                        </p>
                    @endif

                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
