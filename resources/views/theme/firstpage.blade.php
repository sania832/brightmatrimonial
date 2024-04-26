@extends('layouts.theme.master')

@section('content')
	<main>
        <section id="banner-section">
			<div class="container-fluid">
                @if (Auth::user() && Auth::user()->user_type = "Customer")
                    <form class="ai-signup" action="javascript:void(0);" method="POST" onsubmit="partnerPreference();">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-lg">
                                <label for="looking_for">Looking for</label>
                                <select class="custom-select" id="looking_for" name="looking_for">
                                    <option value="">select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg agefromto">
                                <div><label for="from_age">Age</label>
                                    <select class="custom-select" id="from_age" name="from_age">
                                        <option value="">select</option>
                                        @for ($i=21;$i<40;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div><label class="mb-0">To</label>
                                </div>
                                <div><label for="to_age">Age</label>
                                    <select class="custom-select " id="to_age" name="to_age">
                                        <option value="">select</option>
                                        @for ($i=21;$i<40;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg">
                                <label for="religion">Religion</label>
                                <select class="custom-select" name="religion" id="religion">
                                    <option value="" selected>Select</option>
                                    @foreach($options['religion'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg">
                                <label for="mother_tongue">Mother Tough</label>
                                <select class="custom-select" name="mother_tounge" id="mother_tounge">
                                    <option value="" selected>Select</option>
                                    @foreach($options['mother_tongue'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-2 text-center">
                                <button type="submit" class="btn btn-submit">Let's start</button>
                            </div>
                        </div>
                    </form>
                @endif
			</div>
		</section>

		<section id="features" class="section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="theme-title text-center">
							<h2>Fratures</h2>
							<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="fratures-box">
							<div class="fra__img-box">
								<img src="{{ asset('themeAssets/images/feature-01.svg') }}" alt="" width="60">
							</div>
							<div class="fra__title">
								<h4>100% Confidential</h4>
							</div>
							<div class="fra__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore edolore magna aliquyam erat,</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="fratures-box">
							<div class="fra__img-box">
								<img src="{{ asset('themeAssets/images/feature-02.svg') }}" alt="" height="136">
							</div>
							<div class="fra__title">
								<h4>Highly Related Match</h4>
							</div>
							<div class="fra__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore edolore magna aliquyam erat,</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="fratures-box">
							<div class="fra__img-box">
								<img src="{{ asset('themeAssets/images/feature-03.svg') }}" alt="" height="100">
							</div>
							<div class="fra__title">
								<h4>LGBT Match</h4>
							</div>
							<div class="fra__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore edolore magna aliquyam erat,</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section id="WhyChooseUs" class="section">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="theme-title text-center">
							<h2>Why Choose us ?</h2>
							<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
						</div>
					</div>
				</div>
				<div class="row whychooseus-main align-items-center">
					<div class="col-12 col-lg-6 ">
						<div class="whychooseus-box">
							<img src="{{ asset('themeAssets/images/why-choose-us.svg') }}" alt="">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="whychooseus-content">
							<div class="whychooseus__title">
								<h4>1 ) Feature 1</h4>
							</div>
							<div class="whychooseus__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
									eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
									takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,
									consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
									dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
									dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem
									ipsum dolor sit amet.</p>
							</div>
						</div>
						<div class="whychooseus-content">
							<div class="whychooseus__title">
								<h4>2 ) Feature 2</h4>
							</div>
							<div class="whychooseus__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
									eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
									takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,
									consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
									dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
									dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem
									ipsum dolor sit amet.</p>
							</div>
						</div>
						<div class="whychooseus-content">
							<div class="whychooseus__title">
								<h4>3 ) Feature 3</h4>
							</div>
							<div class="whychooseus__des">
								<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
									tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
									eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
									takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,
									consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
									dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
									dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem
									ipsum dolor sit amet.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
@endsection

@section('js')

	@if(Auth::user() && Auth::user()->user_type != "superAdmin")
		@if(Auth::user()->step_complete < 7)
			<script>
				swal.fire({
					//type: 'success',
					title: 'Complete Profile',
					html: '<br><br><p>Look like you have incomplete profile right now!!</p>',
					showCancelButton: true,
					confirmButtonText: 'Yes, do it!',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					showCancelButton: true,
					showCloseButton: true
				}).then(function(isConfirm) {
					if (isConfirm.value) { window.location.href = SITE_URL+'/complete-profile'; };
				});
			</script>
		@endif
	@endif

    <script src="{{ asset('/authAssets/custom.js') }}"></script>

@endsection
