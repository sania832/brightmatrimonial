					<div id="step-3" class="your-family-details-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Your Family Details</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
								<ul class="step-list">
									<li class="active"></li>
									<li class="active"></li>
									<li class="active"></li>
									<li></li>
									<li></li>
									<li></li>
									<li></li>
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
										<label for="mother_occupation">Mother's Occupation*</label>
										<select class="custom-select " name="mother_occupation" id="mother_occupation">
											<option value="" selected>Select</option>
											@foreach($options['mother_occupation'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-mother_occupation"></div>
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
										<label>Number of siblings*</label>
										<select class="custom-select " name="number_of_siblings" id="number_of_siblings">
											<option value="0" selected>0</option>
											<option value="1">1</option>
											<option value="2" >2</option>
											<option value="3" >3</option>
											<option value="4" >4</option>
											<option value="5" >5</option>
											<option value="6" >6</option>
											<option value="7" >7</option>
											<option value="8" >8</option>
											<option value="9" >9</option>
											<option value="10" >10+</option>
										</select>
										<div class="validation-div val-number_of_siblings"></div>
									</div>
								</div>
							</div>
							
							
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(3);" class="btn btn-sign mb-0">Continue</button>
								<p class="sign-up-text">By Submit ,you agree to our <a href="{{ url('terms') }}">Terms</a></p>
							</div>
						</div>
					</div>
@section('js')
		<script>
			$("#cast option[value='{{ $data->cast }}']").attr("selected", true);
			$("#family_type option[value='{{ $data->family_type }}']").attr("selected", true);
			$("#father_occupation option[value='{{ $data->father_occupation }}']").attr("selected", true);
			$("#mother_occupation option[value='{{ $data->mother_occupation }}']").attr("selected", true);
			console.log('Mother Occupation');
			$("#number_of_siblings option[value='{{ $data->number_of_siblings }}']").attr("selected", true);
		</script>
@endsection
