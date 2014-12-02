<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CSCI 370</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	@yield('include')
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h2>CSCI 370 Registration</h2>
				<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse">
					<p class="navbar-text" style="font-size:1.4em"> @yield('header')</p>
						
						@if(Auth::check())
							<a href="{{URL::to('/Logout')}}" class="btn btn-default navbar-right navbar-btn">Log Out</a>
							@if(Auth::user()->PermissionLevel < 2)
								<a href="{{URL::to('/Student/Info')}}" class="btn btn-default navbar-right navbar-btn">My Info</a>
							@else
								<a href="{{URL::to('/Admin')}}" class="btn btn-default navbar-right navbar-btn">Admin</a>
							@endif
						@endif
				</div>	
				</nav>
			</div>
			<div class="content">
				@yield('content')
			</div>
		</div>
	</body>
</html>