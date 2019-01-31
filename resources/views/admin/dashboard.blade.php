@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.dashboard'))
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
                        onclick="openClientForm()"
                    >
                        <i class="fas fa-user-plus mr-1"></i>
                        @lang('admin.users.index.createclient')
                    </a>

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
                            @include('admin.dashboard.table', [
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
                            @include('admin.dashboard.table', [
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
	<div class="modal fade" id="client_create_modal" tabindex="-1" role="dialog" aria-labelledby="client_create_modal">
		<div style="max-width:80%;" class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
			@lang('user.form-settings.basic-information')
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			
			</div>
			<div class="modal-body">
				{!!
					Form::open([
						'url' => url('admin/users/createclient')
					])
				!!}
				@include('admin.users.client.form-client', [
					'features' => [
						'license' => true,
					],
				])
				{!! Form::close() !!}
			</div>

		</div>
		</div>
	</div>
	<script type="text/javascript">
	function openClientForm(){
		$('#client_create_modal').modal('show');
	}
	</script>
@endsection
