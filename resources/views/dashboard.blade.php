@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('dashboard'))
@section('content.dashboard')
@if(Auth::user()->isClient())
<div class="container ">
<div class="row">
	<div class="col-sm-6 mb-4">
    <div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a class="card-title">
                    Personal Information
                </a>
            </div>
            <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<ul class="list-group">
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>Name :</b></div><div class="col-sm-6">{!! $user->name !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>Email :</b></div><div class="col-sm-6">{!! $user->email !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>Work Phone :</b></div><div class="col-sm-6">{!! $user->work_phone  !!}</div></div></li>
						<li class="list-group-item"><div class="row"><div class="col-sm-6"><b>Health Insurance Number :</b></div><div class="col-sm-6">{!! $user->health_card_number !!}</div></div></li>
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
                    Scores
                </a>
            </div>
            <div id="collapseTwo" class="card-body collapse show" data-parent="#accordion" >
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
	<div class="col-sm-6">
    <div id="accordion" class="accordion">
        <div class="card">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                <a class="card-title">
                    Appointments
                </a>
            </div>
            <div id="collapseThree" class="card-body collapse" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-6">
						<h6>Past</h6>
					<ul class="list-group">
					@foreach($communication as $logs)
						@if($logs->appointment_date < date('Y-m-d'))
							<li class="list-group-item"> {{ $logs->appointment_date }} </li>
						@endif
					@endforeach
					</ul>
					</div>
					<div class="col-sm-6">
						<h6>Upcoming</h6>
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
                    Notes
                </a>
            </div>
            <div id="collapseFour" class="card-body collapse" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
						
					<ul class="list-group">
					@foreach($notes as $note)
						
							<li class="list-group-item"> {!! $note->contents !!} </li>
						
					@endforeach
					</ul>
					</div>

				</div>
            </div>
        </div>
    </div>
	</div>
@php

 foreach($responses as $response) {

$years[] =date('Y',strtotime($response->updated_at));
$months[] =date('m',strtotime($response->updated_at));
$days[] =date('d',strtotime($response->updated_at));
	if($score[$response->uuid] != ''){
		$sc[]=$score[$response->uuid];
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
					<div id="chart_div"></div>
					
					</div>

				</div>
            </div>
        </div>
    </div>
	</div>
</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', 'Score');

        data.addRows([
		@php  for($i=0;$i<count($years);$i++){ @endphp
          [new Date(@php echo $years[$i];@endphp, @php echo $months[$i];@endphp, @php echo $days[$i];@endphp),@php echo  $sc[$i];@endphp],
		@php } @endphp
        ]);


        var options = {
          title: 'Score the Day on a Scale of 1',
          width: 400,
          height: 400,
          hAxis: {
            format: 'M/d/yy',
            gridlines: {count: 1},
			title: 'Dates'
          },
          vAxis: {
           gridlines: {count: 1},
            minValue: 0,
			title: 'Score'
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);

        var button = document.getElementById('change');

        button.onclick = function () {

          options.hAxis.format === 'M/d/yy' ?
          options.hAxis.format = 'MMM dd, yyyy' :
          options.hAxis.format = 'M/d/yy';

          chart.draw(data, options);
        };
      }

   </script>
@endif

@endsection
