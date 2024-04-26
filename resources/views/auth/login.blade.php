<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="{{env('APP_URL')}}">
    <title>Login - Bright Matrimony</title>
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
							<img src="{{ asset('/authAssets/images/left-banner.svg') }}" alt="">
						</div>
					</div>
					<div class="col-12 col-lg-5">
						<div class="sign-box">
							<img src="{{ asset('/authAssets/images/sign-logo.svg') }}" alt="">
							{{-- <form class="ai-signin" action="{{ route('loginUser') }}" method="POST"> --}}
							<form class="ai-signin" action="javascript:void(0);" method="POST" onsubmit="loginUser();">
								@csrf
								<div class="form-group mb-2">
								  <label for="email">Email Id or Mobile No</label>
								  <input type="email" class="form-control" name='email' id="email" placeholder="Enter Email Id or Mobile No" autocomplete="username">
								  <div class="validation-div val-email"></div>
								</div>
								<div class="form-group">
								  <label for="password">Password</label>
								  <input type="password" class="form-control" name='password' id="password" placeholder="Enter Password" autocomplete="current-password">
								  <div class="validation-div val-password"></div>
								</div>
								<a class="forgot-password" href="javascript:void(0);">Forgot password?</a>
								<button type="submit" class="btn btn-sign">Login</button>
								<p class="sign-up-text">New Member ? <a href="{{ url('register') }}">Sign Up</a></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</body>
	<script type="text/javascript" src="{{ asset('/authAssets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/owl.carousel.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/authAssets/js/common.js') }}"></script>
	
	<!-- Sweetalert -->
	<script src="{{ asset('/authAssets/sweetalert/sweetalert2.js') }}"></script>
	
	<!-- custom js -->
    <script src="{{ asset('/authAssets/custom.js') }}"></script>
</html>