@section('css')
	<link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-u3h5SFn5baVOWbh8UkOrAaLXttgSF0vXI15ODtCSxl0v/VKivnCN6iHCcvlyTL7L" crossorigin="anonymous">
@endsection

<div id="step-5" class="describe-your-self-step">
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="form-step-title">
				<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
				<h2>Desired Partner</h2>
				<img src="images/title-border.svg" alt="" width="550">
			</div>
			<ul class="step-list">
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				{{-- <li></li> --}}
			</ul>
		</div>
		<div class="col-6">
			<div class="sign-box align-items-start">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<label>Min Age</label>
									<select class="custom-select" name="min_age">
										@for($i=18; $i < 50; $i++)
										<option value="{{$i}}">{{$i}}</option>
										@endfor
									</select>
								</div>
								<div class="col-6">
									<label>Max Age</label>
									<select class="custom-select" name="max_age">
										@for($i=20; $i < 50; $i++)
										<option value="{{$i}}">{{$i}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="validation-div val-age"></div>
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
							<label>Relation Type</label>
							<select class="custom-select" id="relation_type" name="relation_type">
								<option  selected>Select</option>
								@foreach($options['relation_type'] as $key => $value)
									<option value="{{ $key }}" @if($data->relation_type == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-relation_type"></div>
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
							<label>Religion</label>
							<select class="custom-select" id="partner_religion" name="partner_religion">
								<option  selected>Select</option>
								@foreach($options['religion'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_religion == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_religion"></div>
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
							<label>Mother Tongue</label>
							<select class="custom-select" id="partner_mother_tongue" name="partner_mother_tongue">
								<option  selected>Select</option>
								@foreach($options['mother_tongue'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_mother_tongue == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_mother_tongue"></div>
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
							<label>Diet</label>
							<select class="custom-select" id="partner_diet_preferences" name="partner_diet_preferences">
								<option  selected>Select</option>
								@foreach($options['diet'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_diet_preferences == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_diet_preferences"></div>
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
							<label>State</label>
							<select class="custom-select" id="partner_state_living_in" name="partner_state_living_in">
								<option  selected>Select</option>
								@foreach($options['state'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_state_living_in == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_state_living_in"></div>
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
							<label>City</label>
							<select class="custom-select" id="partner_city_living_in" name="partner_city_living_in">
								<option  selected>Select</option>
								@foreach($options['city'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_city_living_in == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_city_living_in"></div>
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
							<label>Highest Qualification</label>
							<select class="custom-select" id="partner_qualifications" name="partner_qualifications">
								<option  selected>Select</option>
								@foreach($options['highest_qualification'] as $key => $value)
									<option value="{{ $key }}" @if($data->partner_qualifications == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_qualifications"></div>
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
							<label>Income</label>
							<select class="custom-select" id="partner_income" name="partner_income">
								<option  selected>Select</option>
								@foreach($options['income'] as $key => $value)
									<option value="{{ $key }}" @if($data->income == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-partner_income"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-12 mt-5 mb-4">
			<div class="row">
				<div class="col-4 col-sm-4 mt-5 mb-4"></div>
				<div class="col-4 col-sm-4 mt-5 mb-4">
					<button type="submit" onclick="updateProfile(5);" class="btn btn-sign w-100 mb-0 verify-btn">Continue</button>
				</div>
				<div class="col-4 col-sm-4 mt-5 mb-4"></div>
			</div>
			<p class="sign-up-text">By Submit ,you agree to our <a href="{{ url('terms') }}">Terms</a></p>
		</div>
		
		<div class="col-12 col-sm-12 mt-4">
			{{-- <p class="sign-up-text">Did't receive the PIN? <a href="javascript:void(0);">Resend PIN</a></p> --}}
		</div>
	</div>
</div>

@section('js')
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/coreui.bundle.min.js" integrity="sha384-JdRP5GRWP6APhoVS1OM/pOKMWe7q9q8hpl+J2nhCfVJKoS+yzGtELC5REIYKrymn" crossorigin="anonymous"></script>
<script>
	$("#relation_type option[value='{{ $data->relation_type }}']").attr("selected", true);
	$("#partner_religion option[value='{{ $data->partner_religion }}']").attr("selected", true);
	$("#partner_mother_tongue option[value='{{ $data->partner_mother_tongue }}']").attr("selected", true);
	$("#partner_diet_preferences option[value='{{ $data->partner_diet_preferences }}']").attr("selected", true);
	$("#partner_state_living_in option[value='{{ $data->partner_state_living_in }}']").attr("selected", true);
	$("#partner_city_living_in option[value='{{ $data->partner_city_living_in }}']").attr("selected", true);
	$("#partner_qualifications option[value='{{ $data->partner_qualifications }}']").attr("selected", true);
	$("#partner_income option[value='{{ $data->partner_income }}']").attr("selected", true);
</script>
@endsection