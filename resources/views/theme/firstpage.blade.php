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
    <link rel="shortcut icon" href="{{ asset('/themeAssets/images/favicon.png')}}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('/themeAssets/images/apple-touch-icon-72x72-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('/themeAssets/images/apple-touch-icon-114x114-precomposed.png')}}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('/themeAssets/images/apple-touch-icon-144x144-precomposed.png')}}">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{asset('/themeAssets/css/style.css')}}" rel="stylesheet">

	  <!-- CUSTOM CSS -->
    <link href="{{asset('/themeAssets/custom.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>var token = '{{ csrf_token() }}'; var SITE_URL = '{{ url("") }}';</script>
  </head>

  <body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-9 flex" style="justify-content: space-between;">
      {{-- Logo --}}
      <div class="flex items-center ml-4">
        <img src="{{ asset('themeAssets/images/logo.svg') }}" alt="Bright Matrimony Logo" class=" logo-img" >
      </div>
      
      <div class="mr-4">
        <!-- Navigation Links (Desktop) -->
        <div class="lg:flex hidden">
            <!-- Login Link -->
            <a href="{{ url('/register') }}" class="menu-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
                <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z"/>
              </svg>
                Register
            </a>
            <!-- Support Link -->
            <a href="{{ url('/support') }}" class="menu-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
                <path d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5"/>
              </svg>
              Support
            </a>
        </div>
        {{-- <!-- Menu Icon for Mobile -->
        <div class="lg:hidden">
          <button id="menu-toggle" class="menu-toggle">
              &#9776; <!-- Hamburger Icon -->
          </button>
        </div>
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="lg:hidden hidden text-white py-4">
          <!-- Login Button (Mobile) -->
          <a href="/login" class="font-bold mx-4 text-lg flex items-center bg-black text-white px-3 py-1 rounded-lg hover:bg-gray-800 transition-colors mb-3">
            <i class="fas fa-sign-in-alt mr-2"></i> Login
          </a>
          <!-- Support Button (Mobile) -->
          <a href="{{ url('/support') }}" class="font-bold mx-4 text-lg flex items-center bg-black text-white px-3 py-1 rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-headset mr-2"></i> Support
          </a>
        </div> --}}
      </div>
      <!-- Mobile Menu (Hidden by default) -->
    </nav>

    {{-- Banner Section --}}
    <section class="hero-section" style="background-image: url('{{ asset('themeAssets/images/mainbanner_enhanced.jpg') }}'); ">
      <!-- Content goes here (e.g., heading, buttons, etc.) -->
    </section>

    {{-- Form
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
      <form class="w-full max-w-6xl p-6">    <!-- Looking For and Age From/To in the same row -->
        <div class="flex flex-row gap-4">
          <div class="flex flex-col flex-1">
            <label for="looking_for" class="text-xs text-gray-700 font-medium">Looking For</label>
            <select id="looking_for" name="looking_for" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">Select</option>
              <option value="bride">Bride</option>
              <option value="groom">Groom</option>
            </select>
          </div>
      
          <div class="flex flex-col flex-1">
            <label for="age_from" class="text-xs text-gray-700 font-medium">Age From</label>
            <input type="number" id="age_from" name="age_from" placeholder="From" class="age-input border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
      
          <div class="flex flex-col flex-1">
            <label for="age_to" class="text-xs text-gray-700 font-medium">Age To</label>
            <input type="number" id="age_to" name="age_to" placeholder="To" class="age-input border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
        </div>
      
        <!-- Religion and Mother Tongue in the same row -->
        <div class="flex flex-row gap-4">
          <div class="flex flex-col flex-1">
            <label for="religion" class="text-xs text-gray-700 font-medium">Religion</label>
            <select id="religion" name="religion" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">Select</option>
              <option value="hindu">Hindu</option>
              <option value="muslim">Muslim</option>
              <option value="christian">Christian</option>
              <option value="other">Other</option>
            </select>
          </div>
      
          <div class="flex flex-col flex-1">
            <label for="mother_tongue" class="text-xs text-gray-700 font-medium">Mother Tongue</label>
            <select id="mother_tongue" name="mother_tongue" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">Select</option>
              <option value="english">English</option>
              <option value="hindi">Hindi</option>
              <option value="tamil">Tamil</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>
      
        <!-- Submit Button -->
        <div class="flex items-center justify-center row-break">
          <button type="submit" href="/register" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 text-xs rounded-lg font-semibold shadow-md hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all">
            Lets Begin!
          </button>
        </div>
      </form>
    </body> --}}

    <!-- Responsive Three-Column Section with Circular Images -->
    <section class="py-8 px-4 pt-4" style="background-color: #f9f0f0;"> <!-- Reduced padding on the section -->
      <div class="max-w-screen-xl mx-auto text-center">
        <h2 class="text-2xl font-bold mt-6 pt-4 mb-6 text-gray-800 font-playfair">Trusted Premium Matrimony Service for Your Perfect Match.</h2> <!-- Reduced font size for heading -->
        <div class="mb-4">
            <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="Title Border" class="mx-auto w-full max-w-[50%] h-auto custom-border"> <!-- Reduced width of title border -->
        </div>
        <!-- Flexbox Wrapper for Services -->
        <div class="row pb-4"> <!-- Reduced gap between boxes -->
          <!-- Service 1 -->
          <div class="col-md-4 col-xl-4 col-xs-12 col-lg-4"> <!-- Reduced padding, margin, and height -->
            <div class="m-3 items-center bg-white p-3 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]">
              <img src="{{ asset('themeAssets/images/feature-01.svg') }}" alt="Service 1" class="" style="width:60px;"> <!-- Reduced image size -->
              <h4 class="text-base font-semibold mb-1 mt-1 text-gray-800 font-playfair">100% Confidential</h4> <!-- Reduced font size -->
              <p class=" mb-1 font-nunito services-text">With 100% confidentiality, your personal information and conversations remain private, allowing you to connect securely and comfortably.</p> <!-- Reduced text size -->
            </div>
          </div>
          <!-- Service 2 -->
          <div class="col-md-4 col-xl-4 col-xs-12 col-lg-4"> <!-- Reduced padding, margin, and height -->
            <div class="m-3 items-center bg-white p-3 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]">
              <img src="{{ asset('themeAssets/images/feature-02.svg') }}" alt="Service 2" class="" style="width:60px;"> <!-- Reduced image size -->
              <h4 class="text-base font-semibold mb-1 mt-1 text-gray-800 font-playfair">Verified Profiles</h4> <!-- Reduced font size -->
              <p class=" mb-1 font-nunito services-text">Our verified profiles ensure that every user is genuine, helping you connect with real individuals for meaningful relationships.</p> <!-- Reduced text size -->
            </div>
          </div>
          <!-- Service 3 -->
          <div class="col-md-4 col-xl-4 col-xs-12 col-lg-4"> <!-- Reduced padding, margin, and height -->
            <div class="m-3 items-center bg-white p-3 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]">
              <img src="{{ asset('themeAssets/images/feature-03.svg') }}" alt="Service 3" class="" style="width:60px;"> <!-- Reduced image size -->
              <h4 class="text-base font-semibold mb-1 mt-1 text-gray-800 font-playfair">Advanced Search Filters</h4> <!-- Reduced font size -->
              <p class=" mb-1 font-nunito services-text">Our advanced search filters allow you to customize your search criteria, making it easier to find your ideal match quickly and efficiently.</p> <!-- Reduced text size -->
            </div>
          </div>
        </div>
      </div>
    </section>
  

    <section class="mt-4 py-4 px-8 bg-[#f5f5dc]">
      <div class="max-w-screen-xl mx-auto text-center">
        
        <!-- Text (Below Image) -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2 font-playfair" style="line-height: 1.4;">
          Register With Us
        </h2>
        <p class="title-sub-text font-playfair" style="line-height: 1.4;">
          "Discover true connections built on trust, safety, and lasting compatibility."
        </p>
        <!-- Title Border Image -->
        <div class="mb-4">
          <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="Title Border" class="mx-auto w-full max-w-[50%] h-auto custom-border">
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row" style="width:100%;">
          <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12" style="display:flex; align-items: center;">
            <form class="ai-signup" action="javascript:void(0);" method="POST" onsubmit="registerUsers();">
              @csrf
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="font-color-red">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter first name">
                    <div class="validation-div val-first_name"></div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="font-color-red">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter last name">
                    <div class="validation-div val-last_name"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="font-color-red">Mobile No.</label>
                    <input type="hidden" value="+91" id="country_code" name="country_code">
                    <input type="number" name="phone_number" class="form-control" id="phone_number" placeholder="Enter mobile number">
                    <div class="validation-div val-country_code"></div>
                    <div class="validation-div val-phone_number"></div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label class="font-color-red">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email address">
                    <div class="validation-div val-email"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group">
                    <label class="font-color-red">Date of birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" placeholder="Enter date of birth">
                    <div class="validation-div val-day"></div>
                    <div class="validation-div val-month"></div>
                    <div class="validation-div val-year"></div>
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group">
                    <label class="font-color-red">Gender</label>
                    <select class="form-control" name="gender" id="gender">
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                    <div class="validation-div val-gender"></div>
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group">
                    <label class="font-color-red">Profile For</label>
                    <select class="form-control" name="profile_for" id="profile_for">
                      <option value="self">Self</option>
                      <option value="son">Son</option>
                      <option value="daughter">Daughter</option>
                      <option value="relative">Relative/Friend</option>
                      <option value="sister">Sister</option>
                      <option value="brother">Brother</option>
                      <option value="client">Client (Marriage Bureau) </option>
                    </select>
                    <div class="validation-div val-profile_for"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="font-color-red">Password</label>
                    <input type="password" name="password" id="password" class="form-control" id="password" placeholder="Enter Password">
                    <div class="validation-div val-password"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="font-color-red">Confirm Password</label>
                    <input type="text" name="password_confirmation" id="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                    <div class="validation-div val-confirm_password"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="form-control btn custom-btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
            <img src="https://brightmatrimonial.com/authAssets/images/left-banner.svg" style="width: 100%; padding:2rem;">
          </div>
        </div>
      </div>
    </section>






    <section class="mt-4 py-4 px-8 bg-[#f5f5dc]" style="background-color:#f9f0f0;">
      <div class="max-w-screen-xl mx-auto text-center">
       
        <!-- Text (Below Image) -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2 font-playfair" style="line-height: 1.4;">
          Why Choose Us
        </h2>
        <p class="title-sub-text font-playfair" style="line-height: 1.4;">
          "Discover true connections built on trust, safety, and lasting compatibility."
        </p>
         <!-- Title Border Image -->
         <div class="mb-4">
          <img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="Title Border" class="mx-auto w-full max-w-[50%] h-auto custom-border">
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-6 px-6" style="background-color:#f9f0f0;">
      {{-- <div class="max-w-screen-xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-4"> --}}
        
        <div class="row">
          <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12">
            <!-- Image (Left Side) -->
            <div class="text-center">
                <img src="{{ asset('themeAssets/images/chose.png') }}" alt="Why Choose Us" class="mx-auto" style="width: 20rem;">
                
            </div>
          </div>
          <div class="col-md-6 col-xl-6 col-xs-12 col-sm-12" style="align-items: center;display: flex;">
            <!-- Text (Right Side) -->
            <div class="">
              <!-- List -->
              <ul class="list-disc pl-5 text-black text-sm why-choose-us-ul" 
                  style="font-family: 'Nunito Sans', sans-serif; font-weight: 400;">
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-person" viewBox="0 0 16 16">
                    <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2v9.255S12 12 8 12s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h5.5z"/>
                  </svg>
                  <strong>Personalized Matches.</strong>
                </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                    <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415"/>
                  </svg>
                  <strong>Verified Profiles.</strong>
                </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-lock2" viewBox="0 0 16 16">
                    <path d="M10 7v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V9.3c0-.627.46-1.058 1-1.224V7a2 2 0 1 1 4 0M7 7v1h2V7a1 1 0 0 0-2 0"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                  </svg>
                  <strong>Privacy & Security.</strong>
                </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                    <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                  </svg>
                  <strong>Reliable Matches.</strong>
                </li>
              </ul>
            </div>
          </div>
        </div>

      {{-- </div> --}}
    </section>

    {{-- =========Footer======== --}}

    <div>
      <!-- Company Section -->
      <div class="footer-section-container pt-4">
        <!-- Company Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Company</h3>
          <ul class="text-black ul-style-none">
            <li><a href="/about-us" class="custom-link">About Us</a></li>
            <li><a href="/contact-us" class="custom-link">Contact Us</a></li>
          </ul>
        </div>
      
        <!-- Privacy Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Privacy</h3>
          <ul class="text-black ul-style-none">
            <li><a href="/terms-of-use" class="custom-link">Terms of Use</a></li>
            <li><a href="/privacy-policy" class="custom-link">Privacy Policy</a></li>
            <li><a href="/marriage-blog" class="custom-link">Marriage Blog</a></li>
          </ul>
        </div>
      
        <!-- Help Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Help</h3>
          <ul class="text-black ul-style-none">
            <li><a href="tel:+919909808976" class="custom-link">+91 9909808976</a></li>
            <li><a href="/support-desk" class="custom-link">Support Desk</a></li>
          </ul>
        </div>
      </div>
    </div>
    {{-- Space --}}
    <section class="py-1 px-6" style="background-color: #fcfcfc; height: 1px;">
      <div class="max-w-screen-xl mx-auto text-center">
      </div>
    </section>
    {{-- Match by --}}
    <section class="py-8 px-6 footer-bg" style="font-family: 'Nunito Sans', sans-serif;">
      <div class="container">
        <div class="row" style="width: 100%;">
          <!-- Match by Cities -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Match by Cities</h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">Mumbai</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Pune</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Delhi</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Ahmedabad</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Bangalore</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Chennai</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Kolkata</a></li>
            </ul>
          </div>
        
          <!-- Caste -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Caste</h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">General</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">OBC</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">SC</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">ST</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Brahmin</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Rajput</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Yadav</a></li>
            </ul>
          </div>
        
          <!-- State -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">State</h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">Andhra Pradesh</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Bihar</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Gujarat</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Karnataka</a></li>
            </ul>
          </div>

          <!-- Community -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Community</h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">Brahmins</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Rajputs</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Yadavs</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Dalits</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Jats</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Kurmis</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Baniyas</a></li>
            </ul>
          </div>
        
          <!-- Marital Status -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Marital Status</h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">Single</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Married</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Divorced</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Widowed</a></li>
            </ul>
          </div>

          <!-- International Shaadi -->
          <div class="col-md-2 col-lg-2 col-sm-4 col-xs-3">
            <h4 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Non Resident Indians
            </h4>
            <ul class="space-y-1 text-white ul-style-none" style="font-family: 'Nunito Sans', sans-serif;">
              <li><a href="/register" class="hover:text-red-500 text-white">Australia</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Singapore</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">Malaysia</a></li>
              <li><a href="/register" class="hover:text-red-500 text-white">UAE</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer Section -->
    <section class="footer-bg text-white py-4">
      <div class="max-w-screen-xl mx-auto text-center">
        <p class="text-sm">© 2025 Bright Matrimonial. All Rights Reserved.</p>
      </div>
    </section>

    {{-- Menu toggle script --}}
    <script>
      document.getElementById('menu-toggle').addEventListener('click', function() {
          // Toggle the active class to show the mobile menu
          this.classList.toggle('active');
          
          // Toggle the visibility of the mobile menu
          const mobileMenu = document.getElementById('mobile-menu');
          if (mobileMenu.style.display === 'block') {
              mobileMenu.style.display = 'none';
          } else {
              mobileMenu.style.display = 'block';
          }
      });
    </script>

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
