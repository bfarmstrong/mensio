@extends('layout.dashboard')

@section('title', __('admin.groups.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.groups.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span>
                <i class="fas fa-list-ul mr-1"></i>
                @lang('admin.groups.index.groups')
            </span>

            <a
                class="btn btn-primary btn-sm ml-auto"
                href="{{ url('admin/groups/create') }}"
            >
                @lang('admin.groups.index.create-groups')
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!!
                        Form::open([
                            'url' => url('admin/groups/search')
                        ])
                    !!}
                    @include('admin.groups.form-search')
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($groups->isNotEmpty())
                        @include('admin.groups.table', ['groups' => $groups])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.groups.index.no-results')
                        </p>
                    @endif

                    {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
