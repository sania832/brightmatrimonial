<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Language" content="en">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{ config('constants.APP_NAME') }} @if(isset($page_title) && $page_title != '' ) {{ ' - '.$page_title}} @endif </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
  <meta name="description" content="">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jQuery -->
  <script src="{{asset('adminAssets/scripts/jquery-3.5.0.min.js')}}"></script>
  
  <link rel="stylesheet" href="{{asset('adminAssets/main.d810cf0ae7f39f28f336.css')}}">
  
  <!-- Sweetalert -->
  <script src="{{asset('adminAssets/sweetalert/sweetalert2.js')}}"></script>

  <!-- CUSTOM CSS -->
  <link rel="stylesheet" href="{{asset('adminAssets/custom.css')}}" />
  
  <!-- CUSTOM JS -->
  <script>var token = '{{ csrf_token() }}'; </script>
  <script src="{{asset('adminAssets/scripts/custom.js') }}"></script>
  
  @yield('css')
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	@yield('popup')
	@yield('filter')
	<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

	  @include('layouts.backend.partials.header')

	  <!-- Content Wrapper. Contains page content -->
	  <div class="app-main">
		@if(Auth()->user()->user_type == 'superAdmin')
			@include('layouts.backend.partials.admin_sidebar')
		@endif
		
		@if(Auth()->user()->user_type == 'Vendor')
			@include('layouts.backend.partials.vendor_sidebar')
		@endif
		<div class="app-main__outer">
			<div class="app-main__inner">
				@yield('content')
			</div>
			@include('layouts.backend.partials.footer')
		</div>
	  </div>
	  
	</div>
	<!-- ./wrapper -->

	<script src="{{asset('adminAssets/scripts/main.d810cf0ae7f39f28f336.js') }}"></script>
	@yield('js')
</body>
</html>
