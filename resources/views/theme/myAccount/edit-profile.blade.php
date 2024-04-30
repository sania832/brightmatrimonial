@extends('layouts.theme.master')

@section('content')

<div class="container">
    <div class="app-page-title app-page-title-simple">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div>
                    <div class="theme-title text-start mb-0">
                        <h2>Profile Edit</h2>
                        <img src="images/title-border.svg" alt="" width="450">
                    </div>
				</div>
			</div>
			{{-- <div class="page-title-actions">
				<div class="page-title-subheading opacity-10">
					<nav class="" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a><i aria-hidden="true" class="fa fa-home"></i></a></li>
							<li class="breadcrumb-item"> <a>{{ trans('user.plural') }}</a></li>
							<li class="active breadcrumb-item" aria-current="page">{{ trans('user.edit') }}</li>
						</ol>
					</nav>
				</div>
			</div> --}}
		</div>
	</div>

	<!-- CONTENT START -->
    <div>
        <!-- Basis Details -->
        <form class="" method="POST" action="{{ route('update-user-bio') }}" enctype="multipart/form-data">
            @csrf
            <div class="main-card mb-2 card">
                <div class="card-body">
                    <h5 class="card-title">Basic Details</h5>
                    <div class="form-row">
                        {{-- Profile Image --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="profile_image">{{ trans('users.profile_picture') }}</label><br>
                                @if($user['profile_image'])
                                    <img width="122" height="122" class="rounded-circle" id="profile_image_preview" src="{{ asset($user['profile_image']) }}">
                                @else
                                    <img width="122" height="122" class="rounded-circle" id="profile_image_preview" src="{{ asset('placeholder_profile_image.png') }}">
                                @endif
                                <!-- Input field for uploading profile image -->
                                <input class="pt-3" type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this, 'profile_image_preview')">
                                <input class="pt-3" type="hidden" name="profile_image" value="{{ $user['profile_image'] }}">
                            </div>
                            @if ($errors->has('profile_image'))
                                <div class="alert alert-danger">
                                    {{$errors->first('profile_image')}}
                                </div>
                            @endif
                        </div>

                        {{-- Cover Image --}}
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="cover_image">{{ trans('users.cover_image') }}</label><br>
                                @if($user['cover_image'])
                                    <img style="max-height:122px;" id="cover_image_preview" src="{{ asset($user['cover_image']) }}">
                                @else
                                    <img style="max-height:122px;" id="cover_image_preview" src="{{ asset('placeholder_cover_image.png') }}">
                                @endif
                                <!-- Input field for uploading cover image -->
                                <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="previewImage(this, 'cover_image_preview')">
                            </div>
                            @if ($errors->has('cover_image'))
                                <div class="alert alert-danger">
                                    {{$errors->first('cover_image')}}
                                </div>
                            @endif
                        </div>
                    </div>

                    <script>
                        // Function to preview image
                        function previewImage(input, imageId) {
                            const file = input.files[0];
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const imageElement = document.getElementById(imageId);
                                imageElement.src = e.target.result;
                            }

                            reader.readAsDataURL(file);
                        }
                    </script>


                    <hr>
                    <div class="form-row">
                        {{-- first name --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="first_name" class="">{{ trans('users.first_name') }}</label>
                                <input id="first_name" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" type="text" class="form-control">
                                <div class="validation-div" id="val-first_name"></div>
                            </div>
                            @if ($errors->has('first_name'))
                                <div class="alert alert-danger">
                                    {{$errors->first('first_name')}}
                                </div>
                            @endif
                        </div>
                        {{--  last name --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="last_name" class="">{{ trans('users.last_name') }}</label>
                                <input id="last_name" name="last_name" value="{{ old('last_name') ? old('last_name'): $user->last_name }}" type="text" class="form-control">
                                <div class="validation-div" id="val-last_name"></div>
                            </div>
                            @if ($errors->has('last_name'))
                                <div class="alert alert-danger">
                                    {{$errors->first('last_name')}}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        {{--  email --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="email" class="">{{ trans('users.email') }}</label>
                                <input id="email" name="email" value="{{ old('email') ? old('email') : $user->email }}" type="text" class="form-control">
                                <div class="validation-div" id="val-email"></div>
                            </div>
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{$errors->first('email')}}
                                </div>
                            @endif
                        </div>
                        {{-- phonr number --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="phone_number" class="">{{ trans('users.phone_number') }}</label>
                                <input id="phone_number" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : $user->phone_number }}" type="text" class="form-control">
                                <div class="validation-div" id="val-phone_number"></div>
                            </div>
                            @if ($errors->has('phone_number'))
                                <div class="alert alert-danger">
                                    {{$errors->first('phone_number')}}
                                </div>
                            @endif
                        </div>
                        {{-- date of birth --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="dob" class="">{{ trans('users.dob') }}</label>
                                <input id="dob" name="dob" value="{{ old('dob') ? old('dob') : $user->dob }}" type="text" class="form-control">
                                <div class="validation-div" id="val-dob"></div>
                            </div>
                            @if ($errors->has('dob'))
                                <div class="alert alert-danger">
                                    {{$errors->first('dob')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bio data -->
            <div class="main-card mb-2 card">
                <div class="card-body">
                    <h5 class="card-title">Bio Data</h5>
                    <hr>
                    <div class="form-row">
                        {{-- religion --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="religion" class="">{{ trans('user_bio.religion') }}</label>
                                <select class="custom-select" name="religion" id="religion">
                                    <option value="" selected>Select</option>
                                    @foreach($options['religion'] as $key => $value)
                                        <option @if(old('religion') == $key) selected @elseif($key == $data->religion) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('religion'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('religion')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- community --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="community" class="">{{ trans('user_bio.community') }}</label>
                                <select class="custom-select" name="community" id="community">
                                    <option value="" selected>Select</option>
                                    @foreach($options['community'] as $key => $value)
                                        <option @if(old('community') == $key || $key == $data->community) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('community'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('community')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- mother_tounge --}}

                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="mother_tongue" class="">{{ trans('user_bio.mother_tongue') }}</label>
                                <select class="custom-select" name="mother_tongue" id="mother_tongue">
                                    <option value="" selected>Select</option>
                                    @foreach($options['mother_tongue'] as $key => $value)
                                        <option @if(old('mother_tounge') == $key || $key == $data->mother_tongue) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="validation-div" id="val-mother_tongue"></div>
                            </div>
                        </div>
                        {{-- living with family --}}

                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="state" class="">State</label>
                                <select class="custom-select " name="state" id="state">
                                    <option value="" selected>Select</option>
                                    @foreach($options['state'] as $key => $value)
                                        <option @if(old('state') == $key || $key == $data->state) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('state')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- city --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="city" class="">{{ trans('user_bio.city') }}</label>
                                <select class="custom-select " name="city" id="city">
                                    <option value="" selected>Select</option>
                                    @foreach($options['city'] as $key => $value)
                                        <option @if(old('city') == $key || $key == $data->city) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('city')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- marital_status --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="marital_status" class="">{{ trans('user_bio.marital_status') }}</label>
                                <select class="custom-select " name="marital_status" id="marital_status">
                                    <option value="" selected>Select</option>
                                    @foreach($options['marital_status'] as $key => $value)
                                        <option @if(old('marital_status') == $key || $key == $data->marital_status) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('state')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- diet --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="diet" class="">{{ trans('user_bio.diet') }}</label>
                                <select class="custom-select " name="diet" id="marital_status">
                                    <option value="" selected>Select</option>
                                    <option @if($options['diet'] = 'Vegitarian' || old('diet') == 'Vegitarian') selected @endif value="Vegitarian">Vegitarian</option>
                                    <option @if($options['diet'] = 'Non-Vegitarian' || old('diet') == 'Non-Vegitarian') selected @endif value="Non-Vegitarian">Non-Vegitarian</option>
                                    <option @if($options['diet'] = 'Ocationally-Non-Vegitarian' || old('diet') == 'Ocationally-Non-Vegitarian') selected @endif value="Ocationally-Non-Vegitarian">Ocationally-Non-Vegitarian</option>
                                    <option @if($options['diet'] = 'Eggitarian' || old('diet') == 'Eggitarian') selected @endif value="Eggitarian">Eggitarian</option>
                                    <option @if($options['diet'] = 'Jain' || old('diet') == 'Jain') selected @endif value="Jain">Jain</option>
                                    <option @if($options['diet'] = 'Vegan' || old('diet') == 'Vegan') selected @endif value="Vegan">Vegan</option>
                                </select>
                                @if ($errors->has('diet'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('diet')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- height --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="height" class="">{{ trans('user_bio.height') }}</label>
                                <select class="custom-select" name="height" id="height">
                                    <option value="" selected>Select</option>
                                    @foreach($options['height'] as $key => $value)
                                        <option @if(old('height') == $key || $key == $data->height) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('height'))
                                <div class="alert alert-danger">
                                    {{$errors->first('height')}}
                                </div>
                            @endif
                        </div>
                        {{-- manglik --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="height" class="">Manglik</label>
                                <select class="custom-select " name="manglik" id="manglik">
                                    <option value="" selected>Select</option>
                                    <option @if($data->manglik == 'Yes' || old('manglik') == 'Yes') selected @endif value="Yes">Yes</option>
                                    <option @if($data->manglik == 'No' || old('manglik') == 'No') selected @endif value="No">No</option>
                                </select>
                            </div>
                            @if ($errors->has('manglik'))
                                <div class="alert alert-danger">
                                    {{$errors->first('manglik')}}
                                </div>
                            @endif
                        </div>
                        {{-- horoscopic require --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="horoscope_require" class="">Horoscopic Required</label>
                                <select class="custom-select " name="horoscope_require" id="manglik">
                                    <option value="" selected>Select</option>
                                    <option @if($data->horoscope_require == 'Yes' || old('horoscope_require') == 'Yes') selected @endif value="Yes">Yes</option>
                                    <option @if($data->horoscope_require == 'No' || old('horoscope_require') == 'No') selected @endif value="No">No</option>
                                </select>
                            </div>
                            @if ($errors->has('horoscope_require'))
                                <div class="alert alert-danger">
                                    {{$errors->first('horoscope_require')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Education and career -->
            <div class="main-card mb-2 card">
                <div class="card-body">
                    <h5 class="card-title">Education & Career</h5>
                    <hr>
                    {{-- {{ dd($data); }} --}}
                    <div class="form-row">
                        {{-- Highest qualification  --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="sister" class="">Highest Qualification</label>
                                <select class="custom-select" name="highest_qualification" id="highest_qualification">
                                    <option value="" selected>Select</option>
                                    @foreach($options['highest_qualification'] as $key => $value)
                                        <option @if(old('highest_qualification') == $key || $data->highest_qualificatin == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('highest_qualification'))
                                <div class="alert alert-danger">
                                    {{$errors->first('highest_qualification')}}
                                </div>
                            @endif
                        </div>
                        {{-- company name --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="company_name" class="">Company Name</label>
                                <input id="company_name" name="company_name" value="{{ (old('company_name')) ? old('company_name') : $data->company_name }}" type="text" class="form-control">
                                <div class="validation-div" id="val-company_name"></div>
                            </div>
                            @if ($errors->has('company_name'))
                                <div class="alert alert-danger">
                                    {{$errors->first('company_name')}}
                                </div>
                            @endif
                        </div>
                        {{-- position --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="position" class="">{{ trans('user_bio.position') }}</label>
                                <select class="custom-select " name="position" id="position">
                                    <option value="" selected>Select</option>
                                    @foreach($options['position'] as $key => $value)
                                        <option @if(old('position') == $key || $key == $data->position) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('position'))
                                <div class="alert alert-danger">
                                    {{$errors->first('position')}}
                                </div>
                            @endif
                        </div>
                        {{-- income type --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="income_type" class="">Income Type</label>
                                {{-- <input id="income_type" value="{{ $data->income_type }}" type="text" class="form-control"> --}}
                                <select class="custom-select" name="income_type" id="income_type">
                                    <option value="">select</option>
                                    <option @if($data->income_type == 'Yearly' || old('income_type') == "Yearly") selected @endif value="Yearly">Yearly</option>
                                    <option @if($data->income_type == 'Monthly' || old('income_type') == "Monthly") selected @endif value="Monthly">Monthly</option>
                                </select>
                            </div>
                            @if ($errors->has('income_type'))
                                <div class="alert alert-danger">
                                    {{$errors->first('income_type')}}
                                </div>
                            @endif
                        </div>
                        {{-- income --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="income" class="">Income</label>
                                <select class="custom-select" name="income" id="income">
                                @if($data->income_type == 'Yearly' || old('income_type') == "Yearly")
                                    @foreach($options['yearly_income'] as $key => $value)
                                        <option @if(old('income') == $key) selected @elseif($key == $data->income) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @elseif($data->income_type == 'Monthly' || old('income_type') == "Monthly")
                                    @foreach($options['monthly_income'] as $key => $value)
                                        <option @if(old('income') == $key) selected @elseif($key == $data->income) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                            @if ($errors->has('income'))
                                <div class="alert alert-danger">
                                    {{$errors->first('income')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Family Deatils -->
            <div class="main-card mb-2 card">
                <div class="card-body">
                    <h5 class="title">Family Details</h5>
                    <hr>
                    <div class="form-row">
                        {{-- cive with family yes or no --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="live_with_family" class="">Live With Family</label>
                                <div class="switch-field">
                                    <select class="custom-select " name="live_with_family" id="live_with_family">
                                        <option value="" selected>Select</option>
                                        <option @if($data->live_with_family == 'Yes' || old('live_With_family') == 'Yes') selected @endif value="Yes">Yes</option>
                                        <option @if($data->live_with_family == 'No' || old('live_with_family') == 'No') selected @endif value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            @if ($errors->has('live_with_family'))
                                <div class="alert alert-danger">
                                    {{$errors->first('live_with_family')}}
                                </div>
                            @endif
                        </div>
                        {{-- family living in --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="family_living_in" class="">{{ trans('user_bio.family_living_in') }}</label>
                                <select class="custom-select " name="family_living_in" id="family_living_in">
                                    <option value="" selected>Select</option>
                                    @foreach($options['family_living_in'] as $key => $value)
                                        <option @if(old('family_living_in') == $key || $key == $data->family_living_in) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('family_living_in'))
                                <div class="alert alert-danger">
                                    {{$errors->first('family_living_in')}}
                                </div>
                            @endif
                        </div>
                        {{-- family contact number --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="family_contact_no" class="">{{ trans('user_bio.family_contact_no') }}</label>
                                <input id="family_contact_no" name="family_contact_no" value="{{ old('family_contact_no') ? old('family_contact_no') : $data['family_contact_no'] }}" type="text" class="form-control">
                            </div>
                            @if ($errors->has('family_contact_no'))
                                <div class="alert alert-danger">
                                    {{$errors->first('family_contact_no')}}
                                </div>
                            @endif
                        </div>
                        {{-- cast --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="cast" class="">{{ trans('user_bio.cast') }}</label>
                                <select class="custom-select " name="cast" id="cast">
                                    <option value="" selected>Select</option>
                                    @foreach($options['cast'] as $key => $value)
                                        <option @if(old('cast') == $key || $key == $data->cast) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('cast'))
                                <div class="alert alert-danger">
                                    {{$errors->first('cast')}}
                                </div>
                            @endif
                        </div>
                        {{-- sub cast --}}
                        {{-- {{ dd($options['sub_cast']); }} --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="sub_cast" class="">{{ trans('user_bio.sub_cast') }}</label>
                                <select class="custom-select " name="sub_cast" id="sub_cast">
                                    <option value="" selected>Select</option>
                                    @foreach($options['sub_cast'] as $key => $value)
                                        <option @if(old('sub_cast') == $key || $key == $data->sub_cast) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('sub_cast'))
                                <div class="alert alert-danger">
                                    {{$errors->first('sub_cast')}}
                                </div>
                            @endif
                        </div>
                        {{-- family type --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="family_type" class="">{{ trans('user_bio.family_type') }}</label>
                                <select class="custom-select" name="family_type" id="family_type">
                                    <option value="" selected>Select</option>
                                    @foreach($options['family_type'] as $key => $value)
                                        <option @if(old('family_type') == $key || $key == $data->family_type) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('family_type'))
                                <div class="alert alert-danger">
                                    {{$errors->first('family_type')}}
                                </div>
                            @endif
                        </div>
                        {{-- father occupation --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="father_occupation" class="">{{ trans('user_bio.father_occupation') }}</label>
                                <select class="custom-select " name="father_occupation" id="father_occupation">
                                    <option value="" selected>Select</option>
                                    @foreach($options['father_occupation'] as $key => $value)
                                        <option @if(old('father_occupation') == $key || $key == $data->father_occupation) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div class="validation-div" id="val-father_occupation"></div>
                            </div>
                            @if ($errors->has('father_occupation'))
                                <div class="alert alert-danger">
                                    {{$errors->first('father_occupation')}}
                                </div>
                            @endif
                        </div>
                        {{-- brother --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="brother" class="">{{ trans('user_bio.brother') }}</label>
                                <select class="custom-select " name="brother" id="brother">
                                    <option value="" selected>Select</option>
                                    <option @if($data->brother == '0' || old('brother') == '0') selected @endif value="0">0</option>
                                    <option @if($data->brother == '1' || old('brother') == '1') selected @endif value="1">1</option>
                                    <option @if($data->brother == '2' || old('brother') == '2') selected @endif value="2">2</option>
                                    <option @if($data->brother == '3' || old('brother') == '3') selected @endif value="3">3</option>
                                    <option @if($data->brother == '3+' || old('brother') == '3+') selected @endif value="3+">3+</option>
                                </select>
                            </div>
                            @if ($errors->has('brother'))
                                <div class="alert alert-danger">
                                    {{$errors->first('brother')}}
                                </div>
                            @endif
                        </div>
                        {{-- sister --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="sister" class="">{{ trans('user_bio.sister') }}</label>
                                <select class="custom-select " name="sister" id="sister">
                                    <option value="" selected>Select</option>
                                    <option @if($data->sister == '0' || old('sister') == '0') selected @endif value="0">0</option>
                                    <option @if($data->sister == '1' || old('sister') == '1') selected @endif value="1">1</option>
                                    <option @if($data->sister == '2' || old('sister') == '2') selected @endif value="2">2</option>
                                    <option @if($data->sister == '3' || old('sister') == '3') selected @endif value="3">3</option>
                                    <option @if($data->sister == '3+' || old('sister') == '3+') selected @endif value="3+">3+</option>
                                </select>
                                <div class="validation-div" id="val-sister"></div>
                            </div>
                            @if ($errors->has('sister'))
                                <div class="alert alert-danger">
                                    {{$errors->first('sister')}}
                                </div>
                            @endif
                        </div>
                        {{-- family_bio --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="family_bio" class="">{{ trans('user_bio.family_bio') }}</label>
                                <textarea name="family_bio" id="family_bio" cols="23" rows="3" style="padding: 5px">{{ old('family_bio') ? old('family_bio') : $data->family_bio }}</textarea>
                            </div>
                            @if ($errors->has('family_bio'))
                                <div class="alert alert-danger">
                                    {{$errors->first('family_bio')}}
                                </div>
                            @endif
                        </div>
                        {{-- family adderess --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="family_address" class="">{{ trans('user_bio.family_address') }}</label>
                                <textarea name="family_address" id="family_address" cols="23" rows="3" style="padding: 5px">{{ (old('family_address')) ? old('family_address') : $data->family_address }}</textarea>
                                <div class="validation-div" id="val-family_address"></div>
                            </div>
                            @if ($errors->has('family_address'))
                                <div class="alert alert-danger">
                                    {{$errors->first('family_address')}}
                                </div>
                            @endif
                        </div>
                        {{-- about --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="about" class="">{{ trans('user_bio.about') }}</label>
                                <textarea name="about" id="about" cols="23" rows="3" style="padding: 5px">{{ old('about') ? old('about') : $data->about }}</textarea>
                            </div>
                            @if ($errors->has('about'))
                                <div id="about" class="invalid-feedback">
                                    {{$errors->first('about')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Document -->
            <div class="main-card mb-2 card">
                <div class="card-body">
                    <h5 class="title">Document</h5>
                    <hr>
                    <div class="form-row">
                        {{-- document type --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="document_type" class="">{{ trans('user_bio.document_type') }}</label>
                                <select class="custom-select " name="document_type" id="document_type">
                                    <option value="" selected>Select</option>
                                        <option @if($data->document_type == 1 || old('document_type') == 1) selected @endif value="1">PAN card</option>
                                        <option @if($data->document_type == 2 || old('document_type') == 2) selected @endif value="2">Voter ID</option>
                                        <option @if($data->document_type == 3 || old('document_type') == 3) selected @endif value="3">Driving License</option>
                                </select>
                            </div>
                            @if ($errors->has('document_type'))
                                <div class="alert alert-danger">
                                    {{$errors->first('document_type')}}
                                </div>
                            @endif
                        </div>
                        {{-- document number --}}
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="document_number" class="">{{ trans('user_bio.document_number') }}</label>
                                <input id="document_number" name="document_number" value="{{ old('document_number') ? old('document_number') : $data['document_number']}}" type="text" class="form-control">
                            </div>
                            @if ($errors->has('document_number'))
                                <div class="alert alert-danger">
                                    {{$errors->first('document_number')}}
                                </div>
                            @endif
                        </div>
                        {{-- document image --}}
                        <div class="col-md-4">
                            <label for="document">Document Image</label>
                            <div class="form-group">
                                <input type="file" class="form-control" id="document" name="document" placeholder="Upload Document"
                                @if($data['document']) value="{{ $data['document'] }}" @endif>
                                {{-- @if($data['document']) <input type="hidden" name="photo" value="{{ $data['document'] }}"/> @endif --}}
                                {{-- @if($data['document']) <div class="valid-feedback" style="display:block;">{{ $data['document'] }}</div> @endif --}}
                                <div class="row">
                                    @if($data['document'])
                                        <div class="col-6">
                                            <img id="document_preview" alt="preview image" style="max-height: 150px;"  src="{{ 'bright-metromonial/public/uploads/2024/04/4d8699157abbd5624731d1373e67df07.png'.asset($data['document'])}}" />
                                        </div>
                                    @else
                                        <div class="col-6">
                                            <img id="document_preview" src="" alt="preview image" style="max-height: 150px;display:none;">
                                        </div>
                                    @endif
                                </div>
                                @if ($errors->has('document'))
                                <div class="alert alert-danger">
                                    {{$errors->first('document')}}
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                    <!-- Centered submit button -->
                    <div class="form-row justify-content-center">
                        <div class="col-md-4 mt-auto mb-4 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#state').change(function() {
        var stateId = $(this).val(); // Get the selected state ID

        // Construct the URL using the state ID
        var url = "{{ url('/') }}/live-data-fetch/" + stateId;

        $.ajax({
            url: url,
            dataType: "json",
            type: 'GET',
            delay: 250,
            success: function(data) {
            console.log('Received City Data', data); // Print the received city data

            // Clear existing options in the city dropdown
            $('#city').empty();

            // Append new options based on the received city data
            $.each(data, function(index, city) {
                $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.log('Error', error); // Print the error message
        }
        });
    });

    $('#income_type').change(function() {

        var incomeType = $(this).val(); // Get the selected state ID

        // Construct the URL using the state ID

        var url = "{{ url('/') }}/live-data-fetch/" + incomeType;

        console.log('income type' + incomeType);

        $.ajax({
            url: url,
            dataType: "json",
            type: 'GET',
            delay: 250,
            success: function(data) {
            console.log('Received income Data', data); // Print the received city data

            // Clear existing options in the city dropdown
            $('#income').empty();

            // Append new options based on the received city data
            $.each(data, function(index, income) {
                $('#income').append('<option value="' + income.id + '">' + income.title + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.log('Error', error); // Print the error message
        }
        });
    });

</script>
@endsection

