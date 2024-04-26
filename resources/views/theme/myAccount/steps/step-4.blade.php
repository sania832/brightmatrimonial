					<div id="step-4" class="describe-your-self-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Describe Your Self</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
								<ul class="step-list">
									<li></li>
									<li></li>
									<li></li>
									<li class="active"></li>
								</ul>
							</div>
							<div class="col-12">
								<div class="sign-box">
									<div class="form-group">
										<label for="about">About Your Self*</label>
										<textarea class="form-control" id="about" rows="10">{{ $data->about }}</textarea>
										<div class="validation-div val-about"></div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Mobile Number*</label>
												<div class="row">
													<div class="col-5 col-sm-4">
														<select class="custom-select" id="country_code">
															<option selected>+91</option>
															<option value="+92">+92</option>
															<option value="+93">+93</option>
															<option value="+94">+94</option>
														</select>
														<div class="validation-div val-country_code"></div>
													</div>
													<div class="col-7 col-sm-8">
														<input type="tel" class="form-control" id="mobile_no" placeholder="Mobile Number" @if($data->family_contact_no) value={{ $data->family_contact_no }} @else value="{{ $data->mobile_no }} @endif">
														<div class="validation-div val-mobile_no"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(4);" class="btn btn-sign mb-0">Create Profile</button>
							</div>
						</div>
					</div>
@section('js')
		<script>
			$("#country_code option[value='{{ $data->country_code }}']").attr("selected", true);
		</script>
@endsection
