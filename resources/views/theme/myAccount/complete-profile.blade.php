@extends('layouts.theme.master')

@section('content')
	<main>
		<section id="form-step-section">
			<div class="container">
				<form id="completeProfile" action="javascript:void(0);" method="POST" onsubmit="updateProfile({{ $step }});">
					@csrf
					@include('theme/myAccount/steps/step-'.$step)
				</form>

				<div class="forgot-password-step d-none">
					<div class="row">
						<div class="col-12 col-sm-12 ">
							<div class="form-step-title">
								<a class="back-icon" href="#"><img src="{{ asset('/themeAssets/images/left-arrow.svg') }}" alt=""></a>
								<h2>Forgot Password</h2>
								<img src="{{ asset('/themeAssets/images/title-border.svg') }}" alt="" width="550">
							</div>
						</div>
						<div class="col-12">
							<form>
								<div class="row">
									<div class="col-12 col-sm-9 col-lg-7 mx-auto ">
										<div class="sign-box">
											<div class="form-group">
												<label for="username">Mobile No./ Email ID</label>
												<input type="text" class="form-control" id="username">
												<p class="sign-up-text pin-verfy-text mt-3 mt-md-5 mb-0">We will send you an Email to reset your password</p>
											</div>
											<div class="col-12 col-sm-12 mt-3 mt-md-5" >
												<button type="submit" class="btn btn-sign mb-1 mb-md-3">Send Email</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="create-new-password-step d-none">
					<div class="row">
						<div class="col-12 col-sm-12 ">
							<div class="form-step-title">
								<a class="back-icon" href="#"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
								<h2>Create New Password</h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
							</div>
						</div>
						<div class="col-12">
							<form>
								<div class="row">
									<div class="col-12 col-sm-9 col-lg-7 mx-auto ">
										<div class="sign-box">
											<div class="form-group">
												<label for="new-password">New Password</label>
												<input type="text" class="form-control" id="new-password">
											</div>
											<div class="form-group">
												<label for="retype-password">Retype Password</label>
												<input type="text" class="form-control" id="retype-password">
											</div>
											<div class="col-12 col-sm-12 mt-3 mt-md-5">
												<button type="submit" class="btn btn-sign mb-1 mb-md-3">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="otp-verify-step d-none">
					<div class="row">
						<div class="col-12 col-sm-12 ">
							<div class="form-step-title">
								<a class="back-icon" href="#"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
								<h2>Verify OTP</h2>
								<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
							</div>
						</div>
						<div class="col-12">
							<form class="digit-group" method="get" class="digit-group" data-group-name="digits"
								data-autosubmit="false" autocomplete="off">
								<div class="row">
									<div class="col-12 col-sm-7 col-lg-6 mx-auto ">
										<div class="sign-box">
											<div class="form-group">
												<label for="new-password">OTP Number</label>
												<div class="input-group">
													<input type="text" id="digit-1" name="digit-1"
														data-next="digit-2" />
													<input type="text" id="digit-2" name="digit-2" data-next="digit-3"
														data-previous="digit-1" />
													<input type="text" id="digit-3" name="digit-3" data-next="digit-4"
														data-previous="digit-2" />
													<input type="text" id="digit-4" name="digit-4" data-next="digit-5"
														dta-previous="digit-3" />
												</div>
											</div>
											<div class="col-12 col-sm-12 mt-3 mt-md-5">
												<button type="submit" class="btn btn-sign mb-1 mb-md-3">Send</button>
											</div>
										</div>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- The Modal -->
	<div class="modal fade upload-image-box" id="uploadImage">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal body -->
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><img class="close-img" src="{{ asset('themeAssets/images/close-img.svg') }}" alt=""></button>
					<div class="row">
						<div class="col-12">
							<form>
								<div class="row web-cam-computer">
									<div class="col-12 col-sm-6 mx-auto ">
										<div class="sign-box br-3">
											<div class="form-group">
												<label for="webCam">
													<img class="webcam-img" src="{{ asset('themeAssets/images/webcam.svg') }}" alt="">
													<span>Click Using Webcam</span>
												</label>
												<input id="webCam" type="file" accept="image/*;capture=camera">
											</div>
										</div>
									</div>
									<div class="col-12 col-sm-6 mx-auto ">
										<div class="sign-box">
											<div class="form-group">
												<label for="filiUpload">
													<img class="computer-img" src="{{ asset('themeAssets/images/computer.svg') }}" alt="">
													<span>Upload From Computer</span>
												</label>
												<input id="filiUpload" type="file">
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade upload-image-box" id="uploadImage2">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal body -->
				<div id="img-modal" class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><img class="close-img" src="{{ asset('themeAssets/images/close-img.svg') }}" alt=""></button>
					<div class="row">
						<div class="col-12">
							<form>
								<div class="row web-cam-computer">
									<div class="col-12 col-sm-6 mx-auto ">
										<div class="sign-box br-3">
											<div class="form-group">
												<label for="webCam2">
													<img class="webcam-img" src="{{ asset('themeAssets/images/webcam.svg') }}" alt="">
													<span>Click Using Webcam</span>
												</label>
												<input id="webCam2" type="file" accept="image/*;capture=camera">
											</div>
										</div>
									</div>
									<div class="col-12 col-sm-6 mx-auto ">
										<div class="sign-box">
											<div class="form-group">
												<label for="filiUpload2">
													<img class="computer-img" src="{{ asset('themeAssets/images/computer.svg') }}" alt="">
													<span>Upload From Computer</span>
												</label>
												<input id="filiUpload2" type="file">
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade upload-guide-box" id="uploadGuide">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<!-- Modal body -->
				<div class="modal-body">
					<div class="d-flex">
						<div class="col-6 border-right">
							<div class="guide-text">
								<p class="text-center">Do this</p>
							</div>
							<hr>
							<div class="d-flex justify-content-around p-0">
								<div class="col-4 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-checkmark.svg') }}" alt="">
										<p>Close UP</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
								<div class="col-4 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-checkmark.svg') }}" alt="">
										<p>Half View</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
								<div class="col-4 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-checkmark.svg') }}" alt="">
										<p>Full View</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
							</div>
							<div class="col-12">
								<li>Your photo should be front facing and your entire face should be visible.</li>
								<li>Ensure that Your photo is recent and not with Group.</li>
								<li>Each photo must be less than 15 MB in Size and must be in one of the following
									formats: JPG,GIF,PNG,BMP of tiff.</li>
							</div>
						</div>
						<div class="col-6">
							<button type="button" class="close" data-dismiss="modal"><img class="close-img" src="{{ asset('themeAssets/images/close-img.svg') }}" alt=""></button>
							<div class="guide-text">
								<p class="text-center">Don't do this</p>
							</div>
							<hr>
							<div class="d-flex justify-content-around">
								<div class="col-12 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-close.svg') }}" alt="">
										<p>Side Face</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-close.svg') }}" alt="">
										<p>Group</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
								<div class="col-12 col-sm-6 col-md-4 my-3">
									<div class="guide-header">
										<img src="{{ asset('themeAssets/images/ionic-md-close.svg') }}" alt="">
										<p>Unclear</p>
									</div>
									<div class="guide-img-box"></div>
								</div>
							</div>
							<div class="col-12">
								<li>Watermarked, digitally enhanced, morphed Photos or Photos with your personal
									information will be rejected.</li>
								<li>Your photo should be front facing and your entire face should be visible.</li>
								<li>Irrelevant Photographs will lead to deactivation of your Profile and Membership.</li>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- /main -->
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function () {
		$('.digit-group').find('input').each(function () {
			$(this).attr('maxlength', 1);
			$(this).on('keyup', function (e) {
				var parent = $($(this).parent());

				if (e.keyCode === 8 || e.keyCode === 37) {
					var prev = parent.find('input#' + $(this).data('previous'));

					if (prev.length) {
						$(prev).select();
					}
				} else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
					var next = parent.find('input#' + $(this).data('next'));

					if (next.length) {
						$(next).select();
					} else {
						if (parent.data('autosubmit')) {
							parent.submit();
						}
					}
				}
			});
		});
	});
	var myInput = document.getElementById('webCam');

	function sendPic() {
		var file = myInput.files[0];
	}

	myInput.addEventListener('change', sendPic, false)
</script>
@endsection
