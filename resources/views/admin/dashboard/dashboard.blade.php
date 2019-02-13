@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('admin.dashboard'))
@section('content.dashboard')
<!-- client starts -->
			<div class="container ">
			<div class="row">
				<div class="col-sm-12 mb-4">
					<div id="accordion" class="accordion">
					<div class="card mb-0">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
						<div class="row">
						<div class="col-sm-6">
						
							Clients
						
						</div>
						<div class="col-sm-6 text-right">
						
							count <b>({{ @count($clients) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Email</th>
								<th>Client Since</th>
								<th>Assign Therapist</th>
								
							  </tr>
							</thead>
							<tbody>
							@foreach($clients as $client) 
								<tr>							
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
									<td style="vertical-align:middle;">
			{!!
                    Form::open([
                        'method' => 'post',
                        'url' => url("admin/users/$client->id/therapistssupervisor"),
                    ])
                !!}

			<div class="input-group">
				
				{!!
					Form::select(
						"therapist_id[$client->id]",
						$not_therapists[$client->id]->pluck('name', 'id'),
						old('therapist_id'),
						['class' => 'form-control cus','placeholder' => 'Select Therapist']
					)
				!!}
			

				{!!
					Form::select(
						"supervisors_id[$client->id]",
						$not_supervisors[$client->id]->pluck('name', 'id'),
						old('supervisors_id'),
						['class' => 'form-control','placeholder' => 'Select Supervisor']
					)
				!!}
				{!!
					Form::hidden("user_id[$client->id]",$client->id)
				!!}
				{!!
					Form::submit(
						__('admin.users.therapists.form-add.save'),
						['class' => 'btn btn-primary']
					)
				!!}
			</div>
				{!! Form::close() !!}
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
					<div class="card mb-0">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
						<div class="row">
						<div class="col-sm-6">
						
							Therapist
						
						</div>
						<div class="col-sm-6 text-right">
						
							count <b>({{ @count($therapists) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseTwo" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Email</th>
								<th>License</th>
								<th>Therapist Since </th>
							  </tr>
							</thead>
							<tbody>
							@foreach($therapists as $therapist) 
								<tr>							
									<td style="vertical-align:middle;">
									<a href="/admin/users/{{ $therapist->id }}" >{!! $therapist->name !!}
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
									{!! $therapist->created_at->toDateString() !!}
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
<!-- Admin starts -->
				<div class="col-sm-12 mb-4">
					<div id="accordion" class="accordion">
					<div class="card mb-0">
					<div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
						<div class="row">
						<div class="col-sm-6">
						
							Admin
						
						</div>
						<div class="col-sm-6 text-right">
						
							count <b>({{ @count($admin) }})</b>
						
						</div>
						</div>
					</div>
					<div id="collapseThree" class="card-body collapse show" data-parent="#accordion" >
						<div class="row">
						<div class="col-sm-12">
							
						<table class="table table-bordered table-sm">
							<thead>
							  <tr>
								<th>Name</th>
								<th>Contact Number</th>
								<th>Email</th>
								<th>Admin Since</th>
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
@endsection
