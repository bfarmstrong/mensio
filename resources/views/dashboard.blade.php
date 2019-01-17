@extends('layout.dashboard')

@section('title', __('dashboard.title'))

@section('content.breadcrumbs', Breadcrumbs::render('dashboard'))
@section('content.dashboard')
@if(Auth::user()->isTherapist())
<div class="container ">
    <div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a class="card-title">
                    Your Clients
                </a>
            </div>
            <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
				<div class="row">
					<div class="col-sm-12">
					<input class="form-control" id="myInput" type="text" placeholder="Search..">
					<br>
                	<table class="table table-striped">
					<thead>
					  <tr>
						<th>Client Name</th>
						<th>Next Appointment Date</th>
						<th>Session Notes</th>
					  </tr>
					</thead>
					<tbody id="myTable">
					@foreach ($communications as $key => $communication)
						@foreach ($communication as $log) 
					  <tr>
						<td>{{ $client_names[$key]->name}}</td>
						<td>{{ $log->appointment_date }}</td>
						<td>{!! $notes[$key]->contents !!}</td>
					  </tr>
						@endforeach
					@endforeach
					</tbody>
					</table>
					</div>
					<!-- <div class="col-sm-2">
						<button type="button" class="btn btn-primary">Primary</button>
						<button type="button" class="btn btn-secondary">Secondary</button>
					</div> -->
				</div>
            </div>
        </div>
    </div>
</div>
@endif
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