					<div id="step-7" class="varification-step">
						<div class="row">
							<div class="col-12 col-sm-12 ">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Varification</h2>
									<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-3 mt-sm-5 mb-4 text-center">
								<h4 class="mb-4">Member verification</h4>
								<p class="sign-up-text pin-verfy-text mt-2 mb-4">We are moving towards a more secure
									platform by verifying our users’ basic details.</p>
								<img class="d-block mx-auto" src="{{ asset('themeAssets/images/shield.svg') }}" alt="">
								<p class="sign-up-text verfy-text mt-4">I want to verify Using</p>
							</div>
							<div class="col-12 verification-tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="document_type nav-link active" href="#pan" role="tab" data-toggle="tab" data-document-type="1">PAN card</a>
									</li>
									<li class="nav-item">
										<a class="document_type nav-link" href="#voter" role="tab" data-toggle="tab" data-document-type="2">Voter ID</a>
									</li>
									<li class="nav-item">
										<a class="document_type nav-link" href="#driving" role="tab" data-toggle="tab" data-document-type="3">Driving License</a>
									</li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content mt-4">
									<div role="tabpanel" class="tab-pane fade in active show" id="pan">
										<form action="javascript:void(0);">
											<div class="row">
												<div class="col-12 col-sm-9 col-lg-7 mx-auto ">
													<div class="sign-box">
														<div class="form-group">
															<label for="pan-card-number">Pan Card Number</label>
															<input type="text" class="form-control" id="document_number1">
															<div class="validation-div val-document_number"></div>
														</div>
														<div class="form-group">
															<label for="upload-pancard">Upload Pancard</label>
															<input type="file" title="" class="form-control" placeholder="" id="fileDocument1" accept="image/png, image/gif, image/jpeg">
															<div class="validation-div val-document"></div>
														</div>
														<div class="form-check">
															<input type="checkbox" class="form-check-input" id="exampleCheck1">
															<label class="form-check-label" for="exampleCheck1">I hereby
																allow Sharley Venture provide above details to verify ID
																document from the Issuing AuthorityThe details will only be
																used for verification purposes and not shared with anyone
																else</label>
														</div>
														<div class="col-12 col-sm-12 mt-5">
															<button type="submit" class="btn btn-sign" onclick="updateProfile(7);">Submit</button>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="voter">
										<form action="javascript:void(0);">
											<div class="row">
												<div class="col-12 col-sm-9 col-lg-7 mx-auto ">
													<div class="sign-box">
														<div class="form-group">
															<label for="voter-card-number">Voter ID Number</label>
															<input type="text" class="form-control" id="document_number2">
															<div class="validation-div val-document_number"></div>
														</div>
														<div class="form-group">
															<label for="upload-voter">Upload Voter ID</label>
															<input type="file" class="form-control" id="fileDocument2" accept="image/png, image/gif, image/jpeg">
															<div class="validation-div val-document"></div>
														</div>
														<div class="form-check">
															<input type="checkbox" class="form-check-input" id="exampleCheck1">
															<label class="form-check-label" for="exampleCheck1">I hereby
																allow Sharley Venture provide above details to verify ID
																document from the Issuing AuthorityThe details will only be
																used for verification purposes and not shared with anyone
																else</label>
														</div>
														<div class="col-12 col-sm-12 mt-5">
															<button type="submit" class="btn btn-sign" onclick="updateProfile(7);">Submit</button>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="driving">
										<form action="javascript:void(0);">
											<div class="row">
												<div class="col-12 col-sm-9 col-lg-7 mx-auto ">
													<div class="sign-box">
														<div class="form-group">
															<label for="driving-license">Driving License Number</label>
															<input type="text" class="form-control" id="document_number3">
															<div class="validation-div val-document_number"></div>
														</div>
														<div class="form-group">
															<label for="upload-driving-license">Upload Driving License</label>
															<input type="file" class="form-control" id="fileDocument3" accept="image/png, image/gif, image/jpeg">
															<div class="validation-div val-document"></div>
														</div>
														<div class="form-check">
															<input type="checkbox" class="form-check-input" id="exampleCheck1">
															<label class="form-check-label" for="exampleCheck1">I hereby
																allow Sharley Venture provide above details to verify ID
																document from the Issuing AuthorityThe details will only be
																used for verification purposes and not shared with anyone
																else</label>
														</div>
														<div class="col-12 col-sm-12 mt-5">
															<button type="submit" class="btn btn-sign" onclick="updateProfile(7);">Submit</button>
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