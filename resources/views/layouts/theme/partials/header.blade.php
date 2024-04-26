	@if($page != 'paymentOrder')
	@if($page == 'home' || $page == 'about-us' || $page == 'contact-us' || $page == 'terms' || $page == 'privacy')
	<header>
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
				<a @if(Auth::user() && Auth::user()->step_complete == 7) href="{{ route('profile') }}" @else href="{{ route('firstPage') }}" @endif class="navbar-brand"><img src="{{ asset('themeAssets/images/logo.svg')}}" alt="Bright Matrimony"></a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
					<div class="one"></div>
					<div class="two"></div>
					<div class="three"></div>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav ml-auto">
						<li clas="navbar-item">
							@if(Auth::user())
								@if(Auth::user()->is_approved == 1)
									<ul class="user-prfile">
										<li class="navbar-item dropdown">
											<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<img src="@if(Auth::user()->profile_image) {{ asset(''. Auth::user()->profile_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" height="84px" width="84px" class="rounded-circle">
											</a>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
												<a class="dropdown-item" href="{{ route('profile') }}">Dashboard</a>
												<a class="dropdown-item" href="{{ route('edit-profile') }}">Edit Profile</a>
												<a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
											</div>
										</li>
									</ul>
								@else
									<a class="nav-link" href="javascript:void(0);" title="Logout" itemprop="url" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign Out</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
								@endif
							@else
								<a href="{{ url('login') }}" title="Contact" class="nav-link">Login</a>
							@endif
						</li>
						<li clas="navbar-item">
							<a href="" title="Contact" class="nav-link">
								<svg xmlns="http://www.w3.org/2000/svg" width="27.378" height="33" class="support-icon"
									viewBox="0 0 27.378 33">
									<g id="help-desk" transform="translate(-43.57 0)">
										<path id="Path_37" data-name="Path 37"
											d="M67.294,17.44h2.284a8.762,8.762,0,0,1,0-10.222H67.552a10.4,10.4,0,0,1,18.129,0H83.655a8.762,8.762,0,0,1,0,10.222h2.284A3.043,3.043,0,0,0,88.978,14.4V10.257a3.024,3.024,0,0,0-.642-1.865,12.38,12.38,0,0,0-23.441,0,3.024,3.024,0,0,0-.642,1.864V14.4a3.043,3.043,0,0,0,3.039,3.039Z"
											transform="translate(-19.35 0)" fill="#a11a2e" />
										<path id="Path_38" data-name="Path 38"
											d="M70.9,306.962a13.961,13.961,0,0,0-27.273-.016,2.438,2.438,0,0,0,2.384,2.944c4.87,0,17.806,0,22.517-.015A2.422,2.422,0,0,0,70.9,306.962Z"
											transform="translate(0 -276.89)" fill="#a11a2e" />
										<path id="Path_39" data-name="Path 39"
											d="M159.815,95.1h4.348a6.769,6.769,0,1,0-1.021,1.936h-3.327A.968.968,0,0,1,159.815,95.1Z"
											transform="translate(-100.477 -80.634)" fill="#a11a2e" />
									</g>
								</svg> Support</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	@else
	<header class="profile-header">
		<nav class="navbar navbar-expand-lg">
			<div class="container d-flex justify-content-between align-items-center">
				<a href="{{ url('/profile') }}" class="navbar-brand"><img src="{{ asset('themeAssets/images/logo.svg')}}" alt="Bright Matrimony"></a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
					<div class="one"></div>
					<div class="two"></div>
					<div class="three"></div>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mx-auto">
						<li class="navbar-item">
							<a href="{{ url('/') }}" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/feather-home.svg')}}" alt="">
								<span>Home</span>
							</a>
						</li>
						<li class="navbar-item">
							<a href="{{route('matchPage')}}" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/feather-users.svg')}}" alt="">
								<span>Matches</span>
							</a>
						</li>
						<li class="navbar-item">
							<a href="{{route('searchMatchesPage')}}" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/map-search.svg')}}" alt="">
								<span>Search</span>
							</a>
						</li>
						<li class="navbar-item">
							<a href="{{route('chatPage')}}" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/feather-inbox.svg')}}" alt="">
								<span>Inbox</span>
							</a>
						</li>
						{{-- <li class="navbar-item">
							<a href="{{route('planPage')}}" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/material-update.svg')}}" alt="">
								<span>Upgrade</span>
							</a>
						</li> --}}
						{{-- <li class="navbar-item">
							<a href="javascript:void(0);" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/material-help-outline.svg')}}" alt="">
								<span>Help</span>
							</a>
						</li>
						<li class="navbar-item">
							<a href="javascript:void(0);" title="Contact" class="nav-link">
								<img src="{{ asset('themeAssets/images/material-notifications-none.svg')}}" alt="">
								<span>Notification</span>
							</a>
						</li> --}}
					</ul>
				</div>
				<ul class="user-prfile">
					<li class="navbar-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="@if(Auth::user() && Auth::user()->profile_image) {{ asset(''. Auth::user()->profile_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" height="84px" width="84px" class="rounded-circle">
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="{{ route('profile') }}">Dashboard</a>
							<a class="dropdown-item" href="{{ route('edit-profile') }}">Edit Profile</a>
							<a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	@endif
	@endif
