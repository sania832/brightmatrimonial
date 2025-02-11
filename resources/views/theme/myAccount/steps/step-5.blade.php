					<div id="step-5" class="describe-your-self-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Horoscope</h2>
									<img src="images/title-border.svg" alt="" width="550">
								</div>
							</div>
							<div class="col-6">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Place Of Birth</label>
												<select class="custom-select" id="place_of_birth" name="place_of_birth">
													<option  selected>Select</option>
													@foreach($options['city'] as $key => $value)
														<option value="{{ $key }}" @if($data->place_of_birth == $key) selected @endif>{{ $value }}</option>
													@endforeach
												</select>
												<div class="validation-div val-place_of_birth"></div>
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
												<label>Date of Birth</label>
												<input type="date" class="custom-select" id="place_of_birth" name="place_of_birth" value="{{ $data->place_of_birth }}">
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
												<label>Time of Birth</label>
												<input type="time" class="custom-select" id="time_of_birth" name="time_of_birth" value="{{ $data->time_of_birth }}">
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
												<label>Zodiac Sign</label>
												<select class="custom-select" id="zodiac_sign" name="zodiac_sign">
													<option selected>Select</option>
													<option value="aries">Aries</option>
													<option value="Taurus">Taurus</option>
													<option value="Gemini">Gemini</option>
													<option value="Cancer">Cancer</option>
													<option value="Leo">Leo</option>
													<option value="Virgo">Virgo</option>
													<option value="Libra">Libra</option>
													<option value="Scorpio">Scorpio</option>
													<option value="Sagittarius">Sagittarius</option>
													<option value="Capricorn">Capricorn</option>
													<option value="Aquarius">Aquarius</option>
													<option value="Pisces">Pisces</option>
												</select>
												<div class="validation-div val-zodiac_sign"></div>
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
												<label>Horoscope Match</label>
												<select class="custom-select" id="horoscope_match" name="horoscope_match">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-horoscope_match"></div>
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
												<label>Manglik Dosha</label>
												<select class="custom-select" id="manglik_dosha" name="manglik_dosha">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-manglik_dosha"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5 mb-4">
								<div class="row">
									<div class="col-4 col-sm-4 mt-5 mb-4"></div>
									<div class="col-4 col-sm-4 mt-5 mb-4">
										<button type="submit" onclick="updateProfile(5);" class="btn btn-sign w-100 mb-0 verify-btn">Submit</button>
									</div>
									<div class="col-4 col-sm-4 mt-5 mb-4"></div>
								</div>
							</div>
							
							<div class="col-12 col-sm-12 mt-4">
								{{-- <p class="sign-up-text">Did't receive the PIN? <a href="javascript:void(0);">Resend PIN</a></p> --}}
							</div>
						</div>
					</div>
@section('js')
	<script>
		$("#manglik_dosha option[value='{{ $data->manglik_dosha }}']").attr("selected", true);
		$("#horoscope_match option[value='{{ $data->horoscope_match }}']").attr("selected", true);
		$("#zodiac_sign option[value='{{ $data->zodiac_sign }}']").attr("selected", true);
	</script>
@endsection