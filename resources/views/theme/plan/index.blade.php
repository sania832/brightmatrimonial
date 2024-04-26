@extends('layouts.theme.master')

@section('content')
		<main>
		<section class="match-banner">
			<img class="match-banner-img" src="{{ asset('themeAssets/images/hero-banner.jpg') }}" alt="">
		</section>
		<section class="match-list common-padding common-bg-pattern">
			<div class="container">
				<div class="row">
					@if($plans)
					@foreach($plans as $key=> $plan)
					<div class="col-sm-12 col-md-6 col-lg-4 mb-2">
						<div class="plan-box">
							<div class="theme-title text-center mb-0">
								<h2>{{ $plan->title }}</h2>
								<img src="images/title-border.svg" alt="">
							</div>
							<p>{{ $plan->tagline }}</p>
							<div class="plan-details">
								<div class="plan-text">
									<img src="images/awesome-check-circle.svg" alt="">
									<p>{{ $plan->line_one }}</p>
								</div>
								<div class="plan-text">
									<img src="images/awesome-check-circle.svg" alt="">
									<p>{{ $plan->line_two }}</p>
								</div>
								<div class="plan-text">
									<img src="images/ionic-md-close-circle.svg" alt="">
									<p>{{ $plan->line_three }}</p>
								</div>
								<div class="plan-text">
									<img src="images/ionic-md-close-circle.svg" alt="">
									<p>{{ $plan->line_four }}</p>
								</div>
								<div class="plan-text">
									<img src="images/ionic-md-close-circle.svg" alt="">
									<p>{{ $plan->line_five }}</p>
								</div>
							</div>
							<form id="planList-{{ $plan->id }}" action="javascript:void(0);">
								<div class="sign-box">
									@if($plan->packages)
									@foreach($plan->packages as $pkey=> $package)
									<div class="form-check">
										<input class="form-check-input" type="radio" name="flexRadioDefault" id="packagesRadio-{{ $package->id }}" value="{{ $package->id }}" @if($package->is_selected == 1) {{ 'checked' }} @endif>
										<label class="form-check-label" for="packagesRadio-{{ $package->id }}">{{ $package->title }} Month</label>
										<p>Price ₹ {{ $package->price }}</p>
									</div>
									@endforeach
									@endif
								</div>
								<button class="btn btn-sign" onclick="createOrder({{ $plan->id }});">Buy Now</button>
							</form>						
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</section>
	</main>
    <!-- /main -->
@endsection

@section('js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>	
	// OPEN RAZORPAY MODEL
	function openRazorpay(data){
		var rzp1 = new Razorpay(data);
		rzp1.open();
		//e.preventDefault();
	}
</script>
@endsection