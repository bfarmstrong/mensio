@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.dashboard'))
@section('content.dashboard')
{!!
	Form::open([
		'method' => 'post',
		'url' => url("admin/users/therapistssupervisor"),
	])
!!}

<!-- client starts -->
			<div class="container ">
			<div class="row">
				<div class="col-sm-12 mb-4">
					<div id="accordion" class="accordion">
					<div class="card mb-0" style="border: 1px solid #c8ced3;">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
						<div class="row">
						<div class="col-sm-6">
						
							@lang('admin.dashboard.clients')
						
						</div>
						<div class="col-sm-6 text-right">
						
							@lang('admin.dashboard.count') <b>({{ @count($clients) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>&nbsp;</th>
								<th>@lang('admin.dashboard.name')</th>
								<th>@lang('admin.dashboard.contact_number')</th>
								<th>@lang('admin.dashboard.email')</th>
								<th>@lang('admin.dashboard.client_since')</th>
								
								
							  </tr>
							</thead>
							<tbody>
							@foreach($clients as $client) 
								<tr>
									<td style="vertical-align:middle;">	
										{!!
											Form::checkbox("user_id[]",$client->id)
										!!}								
									</td>									
									<td style="vertical-align:middle;">
									<a href="/clients/{{ $client->id }}/details" >{!! $client->name !!}</a>
									</td>
									<td style="vertical-align:middle;">
									{!! $client->phone !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $client->email !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $client->created_at->toDateString() !!}
									</td>
									
								</tr>
							@endforeach
							</tbody>
						</table>
						</div>
						</div>
					</div>
					</div>
					</div>
				</div>
		
<!-- client end -->
<!-- therapist starts -->
				<div class="col-sm-12 mb-4">
					<div id="accordion" class="accordion">
					<div class="card mb-0" style="border: 1px solid #c8ced3;">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
						<div class="row">
						<div class="col-sm-6">
						
							@lang('admin.dashboard.therapist')
						
						</div>
						<div class="col-sm-6 text-right">
						
							@lang('admin.dashboard.count') <b>({{ @count($therapists) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseTwo" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>&nbsp;</th>
								<th>@lang('admin.dashboard.name')</th>
								<th>@lang('admin.dashboard.address')</th>
								<th>@lang('admin.dashboard.contact_number')</th>
								<th>@lang('admin.dashboard.email')</th>
								<th>@lang('admin.dashboard.license')</th>
								<th>@lang('admin.dashboard.designation')</th>
							  </tr>
							</thead>
							<tbody>
							@foreach($therapists as $therapist) 
								<tr>	
									<td style="vertical-align:middle;">	
										{!!
											Form::checkbox("therapist_id[]",$therapist->id)
										!!}								
									</td>									
									<td style="vertical-align:middle;">
									<a href="/admin/users/{{ $therapist->id }}" >{!! $therapist->name !!}</a>
									</td>
									<td style="vertical-align:middle;">
									{!! $therapist->address_line_1 !!} 
									{!! $therapist->address_line_2 !!}
									{!! $therapist->city !!}
									{!! $therapist->province !!}
									{!! $therapist->postal_code !!}
									{!! $therapist->country !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $therapist->phone !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $therapist->email !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $therapist->license !!}
									</td>
									<td style="vertical-align:middle;">
									@if($therapist->isJuniorTherapist() && $therapist->isSeniorTherapist())
										@lang('admin.dashboard.juniortherapist'), @lang('admin.dashboard.seniortherapist')
									
									@elseif($therapist->isJuniorTherapist())
										@lang('admin.dashboard.juniortherapist')
									
									@elseif($therapist->isSeniorTherapist())
										@lang('admin.dashboard.seniortherapist')
									@endif
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						</div>
						</div>
					</div>
					</div>
					</div>
				</div>
		
<!-- therapist end -->
				<div class="form-row col-12">
						<div class="form-group">
				{!!
						Form::submit(
						__('admin.users.therapists.form-add.save'),
						['class' => 'btn btn-primary']
					)
				!!}
						</div>
					</div>
					</div>
				</div>
			
<!-- Admin starts -->
<div class="container ">
			<div class="row">
				<div class="col-sm-12 mb-4">
					<div id="accordion" class="accordion">
					<div class="card mb-0" style="border: 1px solid #c8ced3;">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
						<div class="row">
						<div class="col-sm-6">
						
							@lang('admin.dashboard.admin')
						
						</div>
						<div class="col-sm-6 text-right">
						
							@lang('admin.dashboard.count') <b>({{ @count($admin) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseThree" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>@lang('admin.dashboard.name')</th>
								<th>@lang('admin.dashboard.contact_number')</th>
								<th>@lang('admin.dashboard.email')</th>
								<th>@lang('admin.dashboard.admin_since')</th>
							  </tr>
							</thead>
							<tbody>
							@foreach($admin as $adm) 
								<tr>							
									<td style="vertical-align:middle;">
									<a href="/admin/users/{{ $therapist->id }}" >{!! $adm->name !!}</a>
									</td>
									<td style="vertical-align:middle;">
									{!! $adm->phone !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $adm->email !!}
									</td>
									<td style="vertical-align:middle;">
									{!! $adm->created_at->toDateString() !!}
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						</div>
						</div>
					</div>
					</div>
					</div>
				</div>
			
		</div>
		</div>
<!-- Admin end -->

{!! Form::close() !!}
@endsection
