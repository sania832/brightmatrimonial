@extends('layouts.theme.master')

@section('content')
	<main class="common-padding">
		<section class="profile-banner">
			<div class="container">
				<div class="profile-img-box">
					<img class="profile-cover" src="@if($user->cover_image) {{ asset(''. $user->cover_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" alt="">
				</div>
				<div class="row profile-detail">
					<div class="col-md-12 col-lg-4 profile-detail-info">
						<div class="profile-img-box">
							<img class="profile-img rounded-circle" src="@if($user->profile_image) {{ asset(''. $user->profile_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" alt="">
							{{-- <a class="add-new" href=""><img class="share-img" src="{{ asset('themeAssets/images/ionic-ios-add.svg') }}"alt=""></a> --}}
						</div>
						<h2>{{ $user->name }}</h2>
						<p>Profile ID : BG{{ $user->id }}</p>
						{{-- <div class="share-info">
							<button class="btn btn-custom">Copy Profile Link</button>
							<a href=""><img class="share-img" src="{{ asset('themeAssets/images/awesome-share-alt.svg') }}" alt=""></a>
						</div> --}}

					</div>
					<div class="col-md-12 col-lg-8 profile-detail-matches">
						<div class="row">
                            @if(session('success'))
                                <div class="col-sm-12 col-md-4 matche-detail">
                                    <button class="btn btn-custom w-100">Already Sent Interest</button>
                                </div>
                            @elseif(session('warn'))
                                <div class="col-sm-12 col-md-4 matche-detail">
                                    <button class="btn btn-custom w-100">Received Interest</button>
                                </div>
                            @elseif(session('info'))
                                <div class="col-sm-12 col-md-4 matche-detail">
                                    <button class="btn btn-custom w-100">Friend Already</button>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-4 matche-detail">
    								<a href="{{ url('/save-interest/' . $user->id) }}"><button class="btn btn-custom w-100">Send Interest</button></a>
                                </div>
                            @endif
							{{-- <div class="col-sm-12 col-md-4 matche-detail">
								<button class="btn btn-custom w-100">Request Chat</button>
							</div> --}}
						</div>
					</div>
				</div>
			</div>
		</section>

		@if($bio)
		<section class="profile-bio profile-bio-other">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-6 mb-3 mb-xl-0">
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">Basic Details</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
							<ul>
								<li>
									<p class="title">Birthdate</p>
									<p class="value">{{ $user->dob }}</p>
								</li>
								<li>
									<p class="title">Religion</p>
									<p class="value">{{ $data['religion'] }}</p>
								</li>
								<li>
									<p class="title">Community</p>
									<p class="value">{{ $data['community'] }}</p>
								</li>
								<li>
									<p class="title">Mother Tongue</p>
									<p class="value">{{ $data['mother_tounge'] }}</p>
								</li>
							</ul>
						</div>

						<div class="p-bio-box">
                            <div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">Profile Details</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
							<ul>
								<li>
									<p class="title">City</p>
									<p class="value">{{ $data['city'] }}</p>
								</li>
								<li>
									<p class="title">Live with your family</p>
									<p class="value">{{ $bio->live_with_family }}</p>
								</li>
								<li>
									<p class="title">Marital Status</p>
									<p class="value">{{ $data['marital_status'] }}</p>
								</li>
								<li>
									<p class="title">Diet</p>
									<p class="value">{{ $bio->diet }}</p>
								</li>
								<li>
									<p class="title">Height</p>
									<p class="value">{{ $data['height'] }}</p>
								</li>
								<li>
									<p class="title">Manglik</p>
									<p class="value">{{ $bio->manglik }}</p>
								</li>
								<li>
									<p class="title">Horoscope necessary</p>
									<p class="value">{{ $bio->horoscope_require }}</p>
								</li>
							</ul>
						</div>

						{{-- <div class="p-bio-box">
                            <div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">Intro Section</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
							<ul>
								<li>
									<p class="title">About Your Self</p>
								</li>
								<li>
									<p class="value">{{ $bio->about }}</p>
								</li>
							</ul>
						</div> --}}

						<div class="p-bio-box">
                            <div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">Education & Career</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
							<ul>
								<li>
									<p class="title">Highest Education</p>
									<p class="value">{{ $data['highest_education'] }}</p>
								</li>
								<li>
									<p class="title">Company Name</p>
									<p class="value">{{ $bio->company_name }}</p>
								</li>
								<li>
									<p class="title">Position</p>
									<p class="value">{{ $data['position'] }}</p>
								</li>
								<li>
									<p class="title">Yearly Income</p>
									<p class="value">{{ $data['income'] }}</p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="p-bio-box">
                            <div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">Family Details</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
                            <ul>
								<li>
									<p class="title">Cast</p>
									<p class="value">{{ $data['cast'] }}</p>
								</li>
								<li>
									<p class="title">Sub-Cast</p>
									<p class="value">{{ $data['sub_cast'] }}</p>
								</li>
								<li>
									<p class="title">Family Type</p>
									<p class="value">{{ $data['family_type'] }}</p>
								</li>
								<li>
									<p class="title">Father occupation</p>
									<p class="value">{{ $data['father_occupation'] }}</p>
								</li>
								<li>
									<p class="title">Brothers</p>
									<p class="value">{{ $bio->brother }}</p>
								</li>
								<li>
									<p class="title">Sister</p>
									<p class="value">{{ $bio->sister }}</p>
								</li>
								<li>
									<p class="title">Select City</p>
									<p class="value">{{ $data['family_living_in'] }}</p>
								</li>
								<li class="flex-column align-items-start">
									<p class="title">Family Bio</p>
									<p class="value">{{ $bio->family_bio }}</p>
								</li>
								<li>
									<p class="title">Family Contact</p>
									<p class="value">{{ $bio->family_contact_no }}</p>
								</li>
							</ul>
						</div>
						<div class="p-bio-box">
                            <div class="theme-title text-center mb-0">
                                <div class="title-wrapper">
                                    <h2><a href="javascript:void(0);">About your Self</a></h2>
                                    <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
                                </div>
							</div>
							<ul>
								<li class="flex-column align-items-start">
									<p class="title">About Your Self</p>
									<p class="value">{{ $bio->about }}</p>
								</li>
								<li>
									<p class="title">Contact </p>
									<p class="value">{{ $bio->mobile_no }}</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endif
	</main>
    <!-- /main -->
@endsection

@section('js')

@endsection
