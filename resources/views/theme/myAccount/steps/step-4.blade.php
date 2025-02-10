					<div id="step-4" class="describe-your-self-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Lifestyle</h2>
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
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Drinking</label>
												<div class="switch-field diet-field">
													@foreach($options['diet'] as $key => $option)
														<input type="radio" id="diet-{{ $key }}" name="diet" value="{{ $key }}" {{ $data->diet == $key ? 'checked' : '' }}>
														<label for="diet-{{ $key }}">{{ $option }}</label>
													@endforeach
												</div>
												<div class="validation-div val-diet"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="sign-box align-items-start">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label>Smoking</label>
												<select class="custom-select" id="smoking">
													<option value="0" selected>Yes</option>
													<option value="1">No</option>
												</select>
												<div class="validation-div val-smoking"></div>
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
			$("#smoking option[value='{{ $data->smoking }}']").attr("selected", true);
		</script>
@endsection
