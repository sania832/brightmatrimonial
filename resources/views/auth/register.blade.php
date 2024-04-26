<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="{{env('APP_URL')}}">
    <title>Registration - Bright Matrimony</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
	<link type="text/css" href="{{asset('/authAssets/css/style.css')}}" rel="stylesheet">
	<link type="text/css" href="{{asset('/authAssets/custom.css')}}" rel="stylesheet">
	<script>var token = '{{ csrf_token() }}'; var SITE_URL = '{{ url("") }}';</script>
</head>

<body>
	<main>
		<section id="sign-section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-lg-7">
						<div class="sign-img">
							<img src="{{ asset('/authAssets/images/left-banner.svg') }}" alt=""/>
						</div>
					</div>
					<div class="col-12 col-lg-5">
						<div class="sign-box">
							<img src="{{ asset('/authAssets/images/sign-logo.svg') }}" alt=""/>
							<form class="ai-signup" action="javascript:void(0);" method="POST" onsubmit="registerUsers();">
								@csrf
								<div class="row">
									<div class="col-12 col-md-6 mb-1">
										<div class="form-group">
											<label for="first_name">First Name</label>
											<input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter First Name"/>
											<div class="validation-div val-first_name"></div>
										</div>
									</div>
									<div class="col-12 col-md-6 mb-1">
										<div class="form-group">
											<label for="last_name">Last Name</label>
											<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Last Name"/>
											<div class="validation-div val-last_name"></div>
										</div>
									</div>
									<div class="col-12 mb-1">
										<div class="form-group">
											<label for="userId">Enter Your Birth date</label>
											<div class="row">
												<div class="col-12 col-md-3 mb-3 mb-md-0">
													<select class="custom-select" name="day" id="day">
														<option value="">Day</option>
														@for ($i = 1; $i <= 31; $i++)
															@php
																$formattedNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
															@endphp
															<option value="{{ $formattedNumber }}">{{ $formattedNumber }}</option>
														@endfor
													</select>
													<div class="validation-div val-day"></div>
												</div>
												<div class="col-12 col-md-4 mb-3 mb-md-0">
													<select class="custom-select" name="month" id="month">
														<option value="">Month</option>
														<option value="01">January</option>
														<option value="02">February</option>
														<option value="03">March</option>
														<option value="04">April</option>
														<option value="05">May</option>
														<option value="06">June</option>
														<option value="07">July</option>
														<option value="08">August</option>
														<option value="09">September</option>
														<option value="10">October</option>
														<option value="11">November</option>
														<option value="12">December</option>
													</select>
													<div class="validation-div val-month"></div>
												</div>
												<div class="col-12 col-md-5 mb-3 mb-md-0">
													<select class="custom-select" name="year" id="year">
														<option value="">Year</option>
														@for($i=1980;$i<=2010;$i++)
															<option value="{{ $i }}">{{ $i }}</option>
														@endfor
													</select>
													<div class="validation-div val-year"></div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12 col-md-3 mb-1">
										<div class="form-group">
											<label for="gender">Gender</label>
											<select class="custom-select " name="gender" id="gender">
												<option value="">Select Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												<option value="Other">Other</option>
											</select>
											<div class="validation-div val-gender"></div>
										</div>
									</div>
									<div class="col-12 col-md-4 mb-1">
										<div class="form-group">
											<label for="profile_for">Profile For</label>
											<select class="custom-select " name="profile_for" id="profile_for">
												<option value="Self">Self</option>
												<option value="Son">Son</option>
												<option value="Daughter">Daughter</option>
												<option value="Relative">Relative/Friend</option>
												<option value="Sister">Sister</option>
												<option value="Brother">Brother</option>
												<option value="Client">Client Marriage Bureau</option>
											</select>
											<div class="validation-div val-profile_for"></div>
										</div>
									</div>

									<div class="col-12 col-md-5 mb-1">
										<div class="form-group">
											<label for="email">Email ID</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Id"/>
											<div class="validation-div val-email"></div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-12 col-md-4 mb-1">
										<div class="form-group">
											<label for="country_code">Code</label>
											<select class="custom-select" name="country_code" id="country_code">
												<option value="+91">+91</option>
												<option value="+92">+92</option>
												<option value="+93">+93</option>
												<option value="+94">+94</option>
												<option value="+95">+95</option>
											</select>
											<div class="validation-div val-country_code"></div>
										</div>
									</div>
									<div class="col-12 col-md-8 mb-1">
										<div class="form-group">
											<label for="phone_number">Mobile No.</label>
											<input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Mobile No."/>
											<div class="validation-div val-phone_number"></div>
										</div>
									</div>

									<div class="col-12 col-md-6">
										<div class="form-group">
											<label for="password">Create Password</label>
											<input type="password" name="password" class="form-control" id="password" placeholder="Enter Password"/>
											<div class="validation-div val-password"></div>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="form-group">
											<label for="confirm_password">Confirm Password</label>
											{{-- <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter Confirm Password"/> --}}
											<input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter Confirm Password" required>
											<div class="validation-div val-confirm_password"></div>
										</div>
									</div>
								</div>
								<button type="submit" class="btn btn-sign">Sign Up</button>
								<p class="sign-up-text">Already Member ? <a href="{{ url('login') }}">Sign In</a></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>

	<script type="text/javascript" src="{{ asset('/authAssets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/owl.carousel.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/common.js') }}"></script>

	<!-- Sweetalert -->
	<script src="{{ asset('/authAssets/sweetalert/sweetalert2.js') }}"></script>

	<!-- custom js -->
    <script src="{{ asset('/authAssets/custom.js') }}"></script>
</body>
</html>
