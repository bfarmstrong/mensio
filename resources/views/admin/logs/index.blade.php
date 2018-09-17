@extends('layout.dashboard')

@section('title', __('admin.logs.index.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.logs.index'))
@section('content.dashboard')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <i class="fas fa-list-ul mr-1"></i>
            @lang('admin.logs.index.activity-log')
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($logs->isNotEmpty())
                        @include('admin.logs.table', ['logs' => $logs])
                    @else
                        <p class="lead text-center text-muted mt-3">
                            @lang('admin.logs.index.no-results')
                        </p>
                    @endif

                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
