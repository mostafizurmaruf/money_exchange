@php
$total_user = DB::table('users')->count();
$total_service = DB::table('gateways')->count();
$total_transection = DB::table('exchanges')->count();
$total_rates = DB::table('rates')->count();
@endphp
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Admin Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="{{asset('')}}assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="{{asset('')}}assets/css/ready.css">
	<link rel="stylesheet" href="{{asset('')}}assets/css/demo.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<div class="logo-header">
				<a href="{{route('dashboard')}}" class="logo">
					Admin Dashboard
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">

					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						
						<li class="nav-item dropdown">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="{{asset('')}}assets/img/profile.jpg" alt="user-img" width="36" class="img-circle"><span >Admin</span></span> </a>
							<ul class="dropdown-menu dropdown-user">
									<a class="dropdown-item" href="{{route('logout')}}"><i class="fa fa-power-off"></i> Logout</a>
								</ul>
								<!-- /.dropdown-user -->
							</li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="sidebar">
				<div class="scrollbar-inner sidebar-wrapper">
					<ul class="nav">
						<li class="nav-item {{Route::currentRouteName() === 'dashboard' ? 'active' : ''}}">
							<a href="{{route('dashboard')}}">
								<i class="la la-dashboard"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item {{Route::currentRouteName() === 'users' ? 'active' : ''}}">
							<a href="{{route('users')}}">
								<i class="la la-user"></i>
								<p>Users</p>
								<span class="badge badge-count text-danger">{{$total_user}}</span>
							</a>
						</li>
						<li class="nav-item {{Route::currentRouteName() === 'exchange' ? 'active' : ''}}">
							<a href="{{route('service')}}">
								<i class="la la-gears"></i>
								<p>Exchange</p>
								<span class="badge badge-count text-primary">{{$total_service}}</span>
							</a>
						</li>
						<li class="nav-item {{Route::currentRouteName() === 'rates' ? 'active' : ''}}">
							<a href="{{route('rates')}}">
								<i class="la la-gears"></i>
								<p>Rates</p>
								<span class="badge badge-count text-primary">{{$total_rates}}</span>
							</a>
						</li>
						<li class="nav-item {{Route::currentRouteName() === 'transection' ? 'active' : ''}}">
							<a href="{{route('transection')}}">
								<i class="la la-list"></i>
								<p>Transection</p>
								<span class="badge badge-count text-info">{{$total_transection}}</span>
							</a>
						</li>
						<li class="nav-item {{Route::currentRouteName() === 'settings' ? 'active' : ''}}">
							<a href="{{route('settings')}}">
								<i class="la la-cog"></i>
								<p>Settings</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">

					@if ($errors->any())
						<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								{{ $error }}
							@endforeach
						</div>
					@endif

					@if(session('success'))
					    <div class="alert alert-success">
					        {{ session('success') }}
					    </div>
					@endif
