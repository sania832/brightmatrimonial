					<div id="step-5" class="verify-your-mobile-number-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Verify your mobile number</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5 mb-4">
								<img class="d-block mx-auto" src="images/mobile.svg" alt="">
								<p class="sign-up-text pin-verfy-text mt-2">We have sent 4 digit PIN to</p>
							</div>
							<div class="col-12 col-sm-6 mx-auto">
								<div class="sign-box">
									<div class="form-group">
										<div class="row">
											<div class="col-12 col-md-8">
												<input type="text" class="form-control" id="otp" placeholder="Enter PIN number">
												<div class="validation-div val-otp"></div>
											</div>
											<div class="col-7 col-md-4 mt-3 mt-md-0 mx-auto mx-md-0">
												<button type="submit" onclick="updateProfile(5);" class="btn btn-sign w-100 mb-0 verify-btn">Verify</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-4">
								<p class="sign-up-text">Did't receive the PIN? <a href="javascript:void(0);">Resend PIN</a></p>
							</div>
						</div>
					</div>