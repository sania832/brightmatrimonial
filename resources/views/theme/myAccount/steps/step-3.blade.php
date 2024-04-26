					<div id="step-3" class="your-family-details-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Your Family Details</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
								<ul class="step-list">
									<li></li>
									<li></li>
									<li class="active"></li>
									<li></li>
								</ul>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="cast">Cast*</label>
										<select class="custom-select " name="cast" id="cast">
											<option value="" selected>Select</option>
											@foreach($options['cast'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-cast"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="sub_cast">Sub-Cast*</label>
										<select class="custom-select " name="sub_cast" id="sub_cast">
											<option value="" selected>Select</option>
											@foreach($options['sub_cast'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-sub_cast"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="family_type">Family Type*</label>
										<select class="custom-select" name="family_type" id="family_type">
											<option value="" selected>Select</option>
											@foreach($options['family_type'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-family_type"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="father_occupation">Father Occupation*</label>
										<select class="custom-select " name="father_occupation" id="father_occupation">
											<option value="" selected>Select</option>
											@foreach($options['father_occupation'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-father_occupation"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label>Brother*</label>
										<div class="switch-field diet-field w-custom">
											<input type="radio" id="brother-0" name="brother" value="0" />
											<label for="brother-0">0</label>
											<input type="radio" id="brother-1" name="brother" value="1" />
											<label for="brother-1">1</label>
											<input type="radio" id="brother-2" name="brother"value="2" />
											<label for="brother-2">2</label>
											<input type="radio" id="brother-3" name="brother"value="3" />
											<label for="brother-3">3+</label>
										</div>
										<div class="validation-div val-brother"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label>Sister*</label>
										<div class="switch-field diet-field w-custom">
											<input type="radio" id="sister-0" name="sister" value="0" />
											<label for="sister-0">0</label>
											<input type="radio" id="sister-1" name="sister" value="1" />
											<label for="sister-1">1</label>
											<input type="radio" id="sister-three" name="sister"value="2" />
											<label for="sister-three">2</label>
											<input type="radio" id="sister-3" name="sister" value="3" />
											<label for="sister-3">3+</label>
										</div>
										<div class="validation-div val-sister"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="family_living_in">Family Living In*</label>
										<select class="custom-select " name="family_living_in" id="family_living_in">
											<option value="" selected>Select</option>
											@foreach($options['family_living_in'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-family_living_in"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="family_bio">Family Bio</label>
										<textarea class="form-control" name="family_bio" id="family_bio" rows="3">{{ $data->family_bio }}</textarea>
										<div class="validation-div val-family_bio"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="family_address">Address</label>
										<textarea class="form-control" name="family_address" id="family_address" rows="3">{{ $data->family_address }}</textarea>
										<div class="validation-div val-address"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="family_contact_no">Contact Number</label>
										<input type="text" class="form-control" name="family_contact_no" id="family_contact_no" placeholder="Enter Contact Number" value="{{ $data->family_contact_no }}">
										<div class="validation-div val-contact_no"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(3);" class="btn btn-sign mb-0">Continue</button>
							</div>
						</div>
					</div>
@section('js')
		<script>
			$("#cast option[value='{{ $data->cast }}']").attr("selected", true);
			$("#sub_cast option[value='{{ $data->sub_cast }}']").attr("selected", true);
			$("#family_type option[value='{{ $data->family_type }}']").attr("selected", true);
			$("#father_occupation option[value='{{ $data->father_occupation }}']").attr("selected", true);
			$("#brother-{{ $data->brother }}").prop("checked", true);
			$("#sister-{{ $data->sister }}").prop("checked", true);
			$("#family_living_in option[value='{{ $data->family_living_in }}']").attr("selected", true);
		</script>
@endsection
