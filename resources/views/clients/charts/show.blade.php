@extends('layout.dashboard')

@section('title', __('clients.chart.title'))
@section('content.breadcrumbs', Breadcrumbs::render('admin.users.charts.title', $user))
@section('content.dashboard')
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
<div id="chart_div"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', 'Score');

        data.addRows([
		@php for($i=0;$i<count($years);$i++){ @endphp
          [new Date(@php echo $years[$i];@endphp, @php echo $months[$i];@endphp, @php echo $days[$i];@endphp),@php echo  $sc[$i];@endphp],
		@php } @endphp
        ]);


        var options = {
          title: 'Score the Day on a Scale of 1',
          width: 900,
          height: 500,
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

          // If the format option matches, change it to the new option,
          // if not, reset it to the original format.
          options.hAxis.format === 'M/d/yy' ?
          options.hAxis.format = 'MMM dd, yyyy' :
          options.hAxis.format = 'M/d/yy';

          chart.draw(data, options);
        };
      }

   </script>
@endsection
