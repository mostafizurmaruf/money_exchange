@include('include.header')
@php
$total_user = DB::table('users')->count();
$total_balance = DB::table('users')->sum('balance');
$total_service = DB::table('gateways')->count();
$total_order = DB::table('exchanges')->count();
@endphp
						<h4 class="page-title">Dashboard</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="card card-stats card-warning">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-users"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Users</p>
													<h4 class="card-title">{{$total_user}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card-stats card-success">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-bar-chart"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Exchange</p>
													<h4 class="card-title">{{$total_service}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card-stats card-primary">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-check-circle"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Transection</p>
													<h4 class="card-title">{{$total_order}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
@include('include.footer')