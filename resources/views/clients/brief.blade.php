@extends('layout.dashboard')

@section('title', __('clients.details.title'))

@section('content.dashboard')

<div class="container ">
<div class="row">
	<div class="col-sm-6 mb-4">
    <div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a class="card-title">
                    @lang('dashboard.personal_information')
                </a>
            </div>
            <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<ul class="list-group">
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>@lang('dashboard.name')</b></div><div class="col-sm-6">{!! $user->name !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>@lang('dashboard.email')</b></div><div class="col-sm-6">{!! $user->email !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>@lang('dashboard.work_phone')</b></div><div class="col-sm-6">{!! $user->work_phone  !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>@lang('dashboard.health_insurance_number')</b></div><div class="col-sm-6">{!! $user->health_card_number !!}</div></div></li>
					</ul> 
					</div>
				</div>
            </div>
        </div>
    </div>
	</div>
	<div class="col-sm-6 mb-4">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseSix">
                <a class="card-title">
                    @lang('dashboard.scores')
                </a>
            </div>
            <div id="collapseSix" class="card-body collapse show" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<ul class="list-group">
					@foreach($scores as $score)
						<li class="list-group-item"> {{ $score }} </li>
					@endforeach
					</ul>
					</div>
				</div>
            </div>
        </div>
    </div>
	</div>
	<div class="col-sm-6 mb-4">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
                <a class="card-title">
                    @lang('dashboard.assigned_personnal') 
                </a>
            </div>
				
            <div id="collapseTwo" class="card-body collapse show" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<table class="table table-bordered table-sm">
						<tbody>
						
							<tr>
								<td>@lang('dashboard.assigned_therapist')</td>
								<td>{!! $therapists !!}</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
            </div>
        </div>
    </div>
	</div>
	<div class="col-sm-6">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                <a class="card-title">
                    @lang('dashboard.appointments')
                </a>
            </div>
            <div id="collapseThree" class="card-body collapse" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-6">
						<h6 class="text-center font-weight-bold">@lang('dashboard.past')</h6>
					<ul class="list-group">
					@foreach($communication as $logs)
						@if($logs->appointment_date < date('Y-m-d'))
							<li class="list-group-item"> {{ $logs->appointment_date }} </li>
						@endif
					@endforeach
					</ul>
					</div>
					<div class="col-sm-6">
						<h6 class="text-center font-weight-bold">@lang('dashboard.upcoming')</h6>
					<ul class="list-group">
					@foreach($communication as $logs)
						@if($logs->appointment_date >= date('Y-m-d'))
							<li class="list-group-item"> {{ $logs->appointment_date }} </li>
						@endif
					@endforeach
					</ul>
					</div>
				</div>
            </div>
        </div>
    </div>
	</div>
	<div class="col-sm-6">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseFour">
                <a class="card-title">
                    @lang('dashboard.notes')
                </a>
            </div>
            <div id="collapseFour" class="card-body collapse" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
						
					<table class="table table-bordered table-sm">
						<thead>
						  <tr>
							<th>Date</th>
							<th>Notes</th>
						  </tr>
						</thead>
					@foreach($notes as $note)

							<tbody>
							<tr>							
								<td style="vertical-align:middle;">
								{!! date('d M Y',strtotime($note->updated_at)) !!}
								</td>
								<td style="vertical-align:middle;">
								{!! $note->contents !!}
								</td>
							</tr>
							</tbody>
							
					@endforeach
					</table>
					</div>

				</div>
            </div>
        </div>
    </div>
	</div>
@php
$years = array();
foreach($responses as $response) {
	$years[] =date('Y',strtotime($response->updated_at));
	$months[] =date('m',strtotime($response->updated_at));
	$days[] =date('d',strtotime($response->updated_at));
	if($scores[$response->uuid] != ''){
		$sc[]=$scores[$response->uuid];
	} else {
		$sc[]=0;
	}
}	
@endphp
	<div class="col-sm-6">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseFive">
                <a class="card-title">
                    Charts
                </a>
            </div>
            <div id="collapseFive" class="card-body collapse" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<canvas id="chLine" ></canvas>
					
					</div>

				</div>
            </div>
        </div>
    </div>
	</div>
</div>
</div>
	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript">
var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];
/* large line chart */
var chLine = document.getElementById("chLine");
var chartData = {
	@php  
		$dates = ''; 
		$score_i = ''; 
	if(!empty($years)){
		
		for($i=0;$i<count($years);$i++){
				$dates .= "'".$years[$i]."-".$months[$i]."-".$days[$i]."',";
				$score_i .= $sc[$i].',';
		} 
	} else {
		$dates .= "'".date('Y')."-".date('m')."-".date('d')."',";
		$score_i .= 0;
	}
	@endphp
		labels: [@php echo $dates; @endphp],
	
  datasets: [{
    data: [@php echo $score_i; @endphp],
    backgroundColor: 'transparent',
    borderColor: colors[0],
    borderWidth: 4,
    pointBackgroundColor: colors[0]
  },
]
};
if (chLine) {
  new Chart(chLine, {
  type: 'line',
  data: chartData,
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: false
    }
  }
  });
}
</script>

@endsection
@push('scripts')
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endpush