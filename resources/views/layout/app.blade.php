<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - @lang('layout.app.title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
		        
    </head>

    <body class="app header-fixed sidebar-fixed sidebar-show">
        @yield('content.main')
	
	<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        @stack('scripts')

	@if (Auth::check() && Auth::user()->first_time_login == 0 )
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
    </body>

</html>
