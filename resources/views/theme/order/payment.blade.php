@extends('layouts.theme.master')

@section('content')
	<main>
		<button type="butoon" id="rzp-button1">Pay Now</button>
	</main>
    <!-- /main -->
@endsection

@section('js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	var options = {
		"key": "rzp_test_7EpAOUQqF7fvt3",
		"amount": 2000, // Example: 2000 paise = INR 20
		"currency": "INR",
		"name": "Bright Matrimony",
		"description": "Plan Payment",
		"image": "http://brightmatrimonial.com/themeAssets/images/logo.svg",
	};
	
	var rzp = new Razorpay(options);

	document.getElementById('rzp-button1').onclick = function(e){
		rzp.open();
		e.preventDefault();
	}
</script>
@endsection