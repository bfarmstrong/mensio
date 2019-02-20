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
						<a
							class="btn btn-primary btn-sm"
							href="{{ url('admin/invite-client') }}"
						>
							<i class="fas fa-user-plus mr-1"></i>
							@lang('admin.dashboard.create-client')
						</a>
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

						<a
							class="btn btn-primary btn-sm"
							href="{{ url('admin/invite-therapist') }}"
						>
							<i class="fas fa-user-plus mr-1"></i>
							@lang('admin.dashboard.create-therapist')
						</a>
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
											Form::checkbox("therapist_id[]",$therapist->id,null,['id'=>'therapist_id[]'])
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
				<div class="form-row col-12 text-center">
						<div class="form-group" style="margin:0 auto 25px;">
				{!!
						Form::submit(
						__('dashboard.associate'),
						['class' => 'btn btn-default associate','disabled' => 'disabled']
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
@push('scripts')
<script type="text/javascript">
jQuery("#collapseOne input:checkbox").click(function(){
	if(jQuery("#collapseOne input:checkbox:checked").length == 0) {
		$('.associate').prop("disabled", true); 
		$('.associate').removeClass('btn-primary');
		$('.associate').removeClass('btn-danger');
		$('.associate').removeClass('btn-success');
		$('.associate').val('Associate');
		$('.associate').addClass('btn-default');
	} else {
		if (jQuery("#collapseTwo input:checkbox:checked").length >= 1 && jQuery("#collapseOne input:checkbox:checked").length >= 1) {
			$('.associate').prop("disabled", false); 
			var therapist_id = [];
			var client_id = [];
			$.each($("#collapseTwo input:checkbox:checked"), function(){            
				therapist_id.push($(this).val());
			});
			$.each($("#collapseOne input:checkbox:checked"), function(){            
				client_id.push($(this).val());
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});

			
			$.ajax({
				type:'POST',
				data: {therapist_id:therapist_id,client_id:client_id},
				url:"/admin/users/checkassignment",
				success:function(data){
					if (jQuery("#collapseTwo input:checkbox:checked").length == 1) {
						if(data == 'De-assign'){
							$('.associate').removeClass('btn-success');
							$('.associate').addClass('btn-danger');
						} else {
							$('.associate').removeClass('btn-danger');
							$('.associate').addClass('btn-success');
						}
						$('.associate').val(data);
					} else {
						$('.associate').removeClass('btn-success');
						$('.associate').removeClass('btn-danger');
						$('.associate').addClass('btn-primary');
						$('.associate').val('Associate');
						alert(data);
					}
					
				}
			});
		} else {
			$('.associate').prop("disabled", true); 
			$('.associate').removeClass('btn-primary');
			$('.associate').removeClass('btn-danger');
			$('.associate').removeClass('btn-success');
			$('.associate').val('Associate');
			$('.associate').addClass('btn-default');
		}
	}
});
jQuery("#collapseTwo input:checkbox").click(function(){
if (jQuery("#collapseTwo input:checkbox:checked").length >= 1 && jQuery("#collapseOne input:checkbox:checked").length >= 1) {
	$('.associate').prop("disabled", false); 
	var therapist_id = [];
	var client_id = [];
	$.each($("#collapseTwo input:checkbox:checked"), function(){            
		therapist_id.push($(this).val());
	});
	$.each($("#collapseOne input:checkbox:checked"), function(){            
		client_id.push($(this).val());
	});
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
	});

    
    $.ajax({
		type:'POST',
		data: {therapist_id:therapist_id,client_id:client_id},
		url:"/admin/users/checkassignment",
        success:function(data){
			if (jQuery("#collapseTwo input:checkbox:checked").length == 1) {
				if(data == 'De-assign'){
					$('.associate').removeClass('btn-success');
					$('.associate').addClass('btn-danger');
				} else {
					$('.associate').removeClass('btn-danger');
					$('.associate').addClass('btn-success');
				}
				$('.associate').val(data);
			} else {
				$('.associate').removeClass('btn-success');
				$('.associate').removeClass('btn-danger');
				$('.associate').addClass('btn-primary');
				$('.associate').val('Associate');
				alert(data);
			}
			
		}
    });
} else {
	$('.associate').prop("disabled", true); 
	$('.associate').removeClass('btn-primary');
	$('.associate').removeClass('btn-danger');
	$('.associate').removeClass('btn-success');
	$('.associate').val('Associate');
	$('.associate').addClass('btn-default');
}
});
</script>
@endpush
@endsection
