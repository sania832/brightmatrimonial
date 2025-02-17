					<div id="step-4" class="describe-your-self-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Lifestyle</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
								<ul class="step-list">
									<li class="active"></li>
									<li class="active"></li>
									<li class="active"></li>
									<li class="active"></li>
									<li></li>
									<li></li>
									<li></li>
									{{-- <li></li> --}}
								</ul>
							</div>
							<div class="col-6">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Drinking</label>
												<select class="custom-select" id="drinking_habits" name="drinking_habits">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-drinking_habits"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Smoking</label>
												<select class="custom-select" id="smoking_habits" name="smoking_habits">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-smoking_habits"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Open to pets</label>
												<select class="custom-select" id="open_to_pets" name="open_to_pets">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-open_to_pets"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Languages Spoken</label>
												<select class="custom-select" id="languages_spoken" name="languages_spoken">
													<option value="" selected>Select</option>
													@foreach($options['language'] as $key => $value)
														<option value="{{ $key }}" @if($data->languages_spoken == $key) selected @endif>{{ $value }}</option>
													@endforeach
												</select>
												<div class="validation-div val-languages_spoken"></div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(4);" class="btn btn-sign mb-0">Continue</button>
								<p class="sign-up-text">By Submit ,you agree to our <a href="{{ url('terms') }}">Terms</a></p>
							</div>
						</div>
					</div>
@section('js')
		<script>
			$("#smoking_habits option[value='{{ $data->smoking_habits }}']").attr("selected", true);
			$("#drinking_habits option[value='{{ $data->drinking_habits }}']").attr("selected", true);
			$("#open_to_pets option[value='{{ $data->open_to_pets }}']").attr("selected", true);
			$("#languages_spoken option[value='{{ $data->languages_spoken }}']").attr("selected", true);
		</script>
@endsection
