<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<base href="{{env('APP_URL')}}">

	<title>@if(isset($page_title) && $page_title != '' ) {{ $page_title.' - '}} @endif {{ config('constants.APP_NAME') }}</title>

	<meta name="author" content="Bright Matrimony">
    <meta name="keywords" content="" />
    <meta name="description" content=""/>

	<!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('favicon.png')}}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('themeAssets/images/apple-touch-icon-72x72-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('themeAssets/images/apple-touch-icon-114x114-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('themeAssets/images/apple-touch-icon-144x144-precomposed.png')}}">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{asset('/themeAssets/css/style.css')}}" rel="stylesheet">

	<!-- CUSTOM CSS -->
    <link href="{{asset('/themeAssets/custom.css')}}" rel="stylesheet">

	<script>var token = '{{ csrf_token() }}'; var SITE_URL = '{{ url("") }}';</script>
	@yield('css')
</head>
<body>

	@if($page != 'complete-profile') @include('layouts.theme.partials.header') @endif

	@include('layouts.theme.partials.navigation')

	@yield('content')

	@if($page != 'complete-profile') @include('layouts.theme.partials.footer') @endif

	<!-- COMMON SCRIPTS -->
	<script type="text/javascript" src="{{asset('/themeAssets/js/jquery-3.5.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/themeAssets/js/bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('/themeAssets/js/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{asset('/themeAssets/js/common.js')}}"></script>

	<!-- Sweetalert -->
	<script src="{{asset('/themeAssets/sweetalert/sweetalert2.js')}}"></script>

    <!-- Custom js -->
    <script src="{{asset('/themeAssets/custom.js')}}"></script>

	@yield('js')
</body>
</html>
