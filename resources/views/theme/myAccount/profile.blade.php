@extends('layouts.theme.master')

@section('content')
	<main class="common-padding">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
		<section class="profile-banner">
			<div class="container">
				<div class="profile-img-box">
					<img class="profile-cover" src="@if(Auth::user()->cover_image) {{ asset(''. Auth::user()->cover_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" alt="">
				</div>
				<div class="row profile-detail">
					<div class="col-md-12 col-lg-4 profile-detail-info">
						<div class="profile-img-box">
							<img class="profile-img rounded-circle" src="@if(Auth::user()->profile_image) {{ asset(''. Auth::user()->profile_image)}} @else {{ asset(config('constants.DEFAULT_USER_IMAGE'))}} @endif" alt="">
							{{-- <a class="add-new" href="{{ url('/complete-profile/6') }}"><img class="share-img" src="{{ asset('themeAssets/images/ionic-ios-add.svg') }}"alt=""></a> --}}
						</div>
						<h2>{{ Auth::user()->name }}</h2>
						<p>Profile ID : BG{{ Auth::user()->id }}</p>
						{{-- <div class="share-info">
							<button class="btn btn-custom">Copy Profile Link</button>
							<a href="javascript:void(0);"><img class="share-img" src="{{ asset('themeAssets/images/awesome-share-alt.svg') }}" alt=""></a>
						</div> --}}
                    </div>
                    <div class="col-md-12 col-lg-8 profile-detail-matches">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 matche-detail">
                                <a class="d-flex flex-column align-items-center" href="{{ route('interest') }}">
                                    <span class="interest-count">{{ $interested }}</span>
                                    <p>Interest Set By You</p>
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-4 matche-detail">
                                <a class="d-flex flex-column align-items-center" href="{{ route('yourMatch') }}">
                                    <span class="interest-count">{{ $my_matches }}</span>
                                    <p>Your Matches</p>
                                </a>
                            </div>
                            <div class="col-sm-12 col-md-4 matche-detail">
                                <a class="d-flex flex-column align-items-center" href="{{ route('viwed-matches') }}">
                                    <span class="interest-count">{{ $viewed_matches }}</span>
                                    <p>Viewed matches</p>
                                </a>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</section>

        @if(!$questions_list->isEmpty())
        <section class="find-prefect-match">
            <div class="container">
                <div class="row prefect-match-box">
                    <div class="col-sm-12 col-lg-4 d-flex justify-content-center align-items-center">
                        <img class="match-box-img" src="{{ asset('themeAssets/images/find-prefect-match-img.svg') }}" alt="">
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <div class="theme-title text-center mb-0">
                            <h2>Find the Prefect Match with Few Answers</h2>
                            <img src="images/title-border.svg" alt="" width="450">
                        </div>
                        <div id="matchQue">
                            @foreach($questions_list as $question)
                            <div class="item">
                                <div class="custom-form" data-question-id="{{ $question->id }}">
                                    <form class="question-form">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ $question[$user->gender] }}</label>
                                            @if($question->options)
                                            <div class="switch-field diet-field">
                                                <div class="row">
                                                    @foreach($question->options as $option)
                                                    <div class="col-12 col-sm-6">
                                                        <input type="radio" id="option-{{ $option->id }}" name="answer_id"
                                                            value="{{ $option->id }}" />
                                                        <label for="option-{{ $option->id }}">
                                                            {{ ($user->gender === 'Male')? $option->Male : $option->Female }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-sign mb-0 mx-auto next-question">Next</button>
                                        {{-- <button type="button" class="btn btn-back mb-0 mx-auto back-question">Back</button> --}}
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- <div class="row prefect-match-box justify-content-center congratulations-box">
                    <div class="col-sm-12 d-flex flex-column justify-content-center align-items-center">
                        <img class="congratulations-box-img" src="{{ asset('themeAssets/images/congratulations-you-got-match.svg') }}" alt="">
                        <p>Congratulations You got a Match</p>
                        <button class="btn btn-custom mb-0 mx-auto">Explore</button>
                    </div>
                </div> --}}
            </div>
        </section>
        @endif

		<section class="profile-bio">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-6 mb-3 mb-xl-0">
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>Basic Details <img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
                                    alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li>
									<p class="title">Birthdate</p>
									<p class="value" id="dob">{{ $user->dob }}</p>
								</li>
								<li>
									<p class="title">Religion</p>
									<p class="value" id="religion">{{ $data['religion'] }}</p>
								</li>
								<li>
									<p class="title">Community</p>
									<p class="value" id="community">{{ $data['community'] }}</p>
								</li>
								<li>
									<p class="title">Mother Tongue</p>
									<p class="value" id="mother_tongue">{{ $data['mother_tounge'] }}</p>
								</li>
							</ul>
						</div>
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>Profile Details<img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
                                    alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li>
									<p class="title">City</p>
									<p class="value" id="city">{{ $data['city'] }}</p>
								</li>
								<li>
									<p class="title">Live with your family</p>
									<p class="value" id="live_with_family">{{ $bio->live_with_family }}</p>
								</li>
								<li>
									<p class="title">Marital Status</p>
									<p class="value" id="marital_status">{{ $data['marital_status'] }}</p>
								</li>
								<li>
									<p class="title">Diet</p>
									<p class="value" id="diet">{{ $bio->diet }}</p>
								</li>
								<li>
									<p class="title">Height</p>
									<p class="value" id="height">{{ $data['height'] }}</p>
								</li>
								<li>
									<p class="title">Manglik</p>
									<p class="value" id="manglik">{{ $bio->manglik }}</p>
								</li>
								<li>
									<p class="title">Horoscope necessary</p>
									<p class="value" id="horoscope_require">{{ $bio->horoscope_require }}</p>
								</li>
							</ul>
						</div>
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>Education & Career<img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
                                    alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li>
									<p class="title">Highest Education</p>
									<p class="value" id="highest_qualification">{{ $data['highest_education'] }}</p>
								</li>
								<li>
									<p class="title">Company Name</p>
									<p class="value" id="company_name">{{ $bio->company_name  }}</p>
								</li>
								<li>
									<p class="title">Position</p>
									<p class="value" id="position">{{ $data['position'] }}</p>
								</li>
								<li>
									<p class="title">Yearly Income</p>
									<p class="value" id="income">{{ $data['income'] }}</p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>Family Details <img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
                                    alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li>
									<p class="title">Cast</p>
									<p class="value" id="cast">{{ $data['cast'] }}</p>
								</li>
								<li>
									<p class="title">Sub-Cast</p>
									<p class="value" id="sub_cast">{{ $data['sub_cast'] }}</p>
								</li>
								<li>
									<p class="title">Family</p>
									<p class="value" id="family_type">{{ $data['family_type'] }}</p>
								</li>
								<li>
									<p class="title">Father occupation</p>
									<p class="value" id="father_occupation">{{ $data['father_occupation'] }}</p>
								</li>
								<li>
									<p class="title">Brothers</p>
									<p class="value" id="brother">{{ $bio->brother }}</p>
								</li>
								<li>
									<p class="title">Sister</p>
									<p class="value" id="sister">{{ $bio->sister }}</p>
								</li>
								<li class="flex-column align-items-start">
									<p class="title">Family Bio</p>
									<p class="value" id="family_bio">{{ $bio->family_bio }}</p>
								</li>
								<li>
									<p class="title">Family Contact</p>
									<p class="value" id="family_contact_no">{{ $bio->family_contact_no }}</p>
								</li>
							</ul>
						</div>
						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>About your Self <img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
											alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li class="flex-column align-items-start">
									<p class="title">About Your Self</p>
									<p class="value" id="about">{{ $bio->about }}</p>
								</li>
								<li>
									<p class="title">Contact </p>
									<p class="value" id="mobile_no">{{ $user->phone_number }}</p>
								</li>
							</ul>
						</div>

						<div class="p-bio-box">
							<div class="theme-title text-center mb-0">
								<h2>Favorite <img class="edit-icon" src="{{ asset('themeAssets/images/awesome-edit.svg') }}"
                                    alt=""></h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="">
							</div>
							<ul>
								<li>
									<p class="title">Favorite Music </p>
									<p class="value" id="favorite_music"></p>
								</li>
								<li>
									<p class="title">Contact </p>
									<p class="value" id=""></p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
    <!-- /main -->
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
	$(document).ready(function(e) {
		getData()
	});

	// GET LIST
	function getData(item_id = ''){
		var data = new FormData();
		data.append('item_id', item_id);

		var response = runAjax('{{route("ajax.profile")}}', data);
		if(response.status == '200'){
			if(response.data){
				$.each(response.data, function( index, value ) {
					$('#'+index).text(value);
				})
			}
		}
	}

    $(document).ready(function() {
        var questions = $(".item");
        var currentQuestionIndex = 0;

        // Function to display the current question
        function displayCurrentQuestion() {
            questions.hide().eq(currentQuestionIndex).show();
        }

        // Display the first question
        displayCurrentQuestion();

        // Handle next question button click
        $(document).on('click', '.next-question', function(e) {
            e.preventDefault();

            // Get the current form and question ID
            var currentForm = $(this).closest('form');

            // If an option is selected, submit the form
            if (currentForm.find('input[type="radio"]:checked').length > 0) {
                // Submit the form asynchronously
                submitAnswer(currentForm);
            }

            // Move to the next question
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                displayCurrentQuestion();
            } else {
                // All questions answered, loop back to the first question
                currentQuestionIndex = 0;
                displayCurrentQuestion();
            }
        });

        // Handle back question button click
        $(document).on('click', '.back-question', function(e) {
            e.preventDefault();

            // Move to the previous question
            currentQuestionIndex--;
            if (currentQuestionIndex < 0) {
                // Last question reached, loop back to the last question
                currentQuestionIndex = questions.length - 1;
            }
            displayCurrentQuestion();
        });

        // Function to submit the answer asynchronously
        function submitAnswer(form) {
            $.ajax({
                url: "{{ route('question_answer') }}",
                method: "POST",
                data: form.serialize(), // Serialize form data
                success: function(response) {
                    console.log('Answer submitted successfully');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('Error submitting answer');
                }
            });
        }
    });

</script>
@endsection
