@extends('layout.app')

@section('content.main')
    @include('layout.navigation')

    <div class="app-body">
        @include('layout.sidebar')
        <main class="main">
            <div class="mb-3">
                @yield('content.breadcrumbs')
                @include('partials.errors')
                @include('partials.message')
            </div>

            <div class="container-fluid mt-3">
                @yield('content.dashboard')
            </div>
        </main>
    </div>
	@if (Auth::user()->first_time_login == 0 )
	<div class="modal fade" id="consentModal"   tabindex="-1" role="dialog" aria-labelledby="consentModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"   data-dismiss="modal" 	  aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			
			</div>
			<div class="modal-body">
				<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="iAccept()" class="btn btn-default" data-dismiss="modal">I Accept</button>
			</div>
		</div>
		</div>
	</div>
	<script type="text/javascript">
			function iAccept(){
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					type:'POST',
					url:"/dashboard",
					success:function(data){
						
					}
				});
			}
			$(window).on('load',function(){
				$('#consentModal').modal('show');
				
			});
	</script>
	@endif
@endsection
