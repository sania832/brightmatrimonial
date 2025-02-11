					<div  id="step-6" class="photos-upload-step">
						<div class="row">
							<div class="col-12">
								<div class="form-step-title">
									{{-- <a class="back-icon" href="{{ url('/complete-profile/'. $step -1 ) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a> --}}
									<h2>Photos Upload</h2>
									<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
									<p class="upload-text">Congratulations!!!!<br> Your Profile Has been Created.</p>
								</div>
							</div>
							<div class="col-12">
								<p class="upload-text"><b>Upload Your Photo and get<br> better matches for you</b></p>
								<div class="cover-profile-main">
									<a class="profile-box" data-toggle="modal" data-target="#uploadImage">
										<div class="camera-img">
											<img class="profile_photo-preview" src="{{ ($data->user->profile_image) ?  asset($data->user->profile_image) : asset('themeAssets/images/camera.svg') }}" alt="">
										</div>
										<span>Profile Photos</span>
										<div class="validation-div val-profile_photo"></div>
									</a>
									<a class="cover-box" data-toggle="modal" data-target="#uploadImage2">
										<div class="camera-img">
											<img class="cover_photo-preview" src="{{ ($data->user->profile_image) ? asset($data->user->cover_image) : asset('themeAssets/images/camera.svg') }}" alt="">
										</div>
										<span>Cover Photo</span>
										<div class="validation-div val-cover_photo"></div>
									</a>
								</div>
								<div class="protected-text"><img src="{{ asset('themeAssets/images/awesome-lock.svg') }}" alt="">
									<p>DCMA Protected Photos</p>
								</div>
								<ul class="upload-img-list">
									<li>
										<img class="upload-img" src="{{ asset('themeAssets/images/upload-img-list.jpg') }}" alt="">
									</li>
									<li>
										<img class="upload-img" src="{{ asset('themeAssets/images/upload-img-list.jpg') }}" alt="">
									</li>
									<li>
										<img class="upload-img" src="{{ asset('themeAssets/images/upload-img-list.jpg') }}" alt="">
									</li>
									<li>
										<img class="upload-img" src="{{ asset('themeAssets/images/upload-img-list.jpg') }}" alt="">
									</li>
									<li>
										<img class="upload-img" src="{{ asset('themeAssets/images/upload-img-list.jpg') }}" alt="">
									</li>
								</ul>
								<a class="upload-guide" data-toggle="modal" data-target="#uploadGuide">Click Me For Photo Upload Guide</a>
								<button class="btn btn-sign mb-1 mb-md-3" onclick="updateProfile('alfa');">Submit</button>
							</div>
						</div>
					</div>
		
@section('js')
    <script>
        $(document).ready(function() {
            $("#filiUpload").change(function () {
                readURL(this, 1);
            });

            $("#filiUpload2").change(function () {
                readURL(this, 2);
            });

            function readURL(input, type = 1) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        if (type == 1) {
                            $('.profile_photo-preview').attr('src', e.target.result);
                            $("#uploadImage .close").trigger("click");
                        } else if (type == 2) {
                            $('.cover_photo-preview').attr('src', e.target.result);
                            $("#uploadImage2 .close").trigger("click");
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Function to display previously uploaded photos
            function displayPreviousPhotos() {
                // Get the src of the previously uploaded profile photo
                var profilePhotoSrc = $('.profile_photo-preview').attr('src');
                // Set the src of the profile photo preview to the previously uploaded photo
                $('.profile_photo-preview').attr('src', profilePhotoSrc);

                // Get the src of the previously uploaded cover photo
                var coverPhotoSrc = $('.cover_photo-preview').attr('src');
                // Set the src of the cover photo preview to the previously uploaded photo
                $('.cover_photo-preview').attr('src', coverPhotoSrc);
            }

            // Call the function to display previously uploaded photos on page load
            displayPreviousPhotos();
        });

    </script>
@endsection
