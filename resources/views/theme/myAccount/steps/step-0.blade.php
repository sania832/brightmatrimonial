					<div id="step-0" class="basic-details-step">
						<div class="row">
							{{-- <input type="hidden" name="step" value="0" id="step"> --}}
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('') }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Great! Now Some Basic Details</h2>
									<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="userId">Enter Your Name</label>
										<div class="row">
											<div class="col-12 col-md-6 mb-3 mb-md-0">
												{{-- <input type="hidden" name="step" value="0"> --}}
												<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="{{ $data->user->first_name }}" autocomplete="first_name">
												<div class="validation-div val-first_name"></div>
											</div>
											<div class="col-12 col-md-6">
												<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="{{ $data->user->last_name }}" autocomplete="last_name">
												<div class="validation-div val-last_name"></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="Religion">Religion</label>
										<select class="custom-select" name="religion" id="religion">
											<option value="" selected>Select</option>
											@foreach($options['religion'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-religion"></div>
									</div>
									<div class="form-group">
										<label for="mother_tounge">Mother Tounge</label>
										<select class="custom-select" name="mother_tounge" id="mother_tounge">
											<option value="" selected>Select</option>
											{{-- @foreach($options['mother_tounge'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach --}}
										</select>
										<div class="validation-div val-mother_tongue"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="userId">Enter Your Birth date</label>
										<div class="row">
											<div class="col-12 col-md-3 mb-3 mb-md-0">
												<select class="custom-select" name="day" id="day">
													<option value="">Day</option>
													@for($i=01;$i<=31;$i++)
														<option @if($i==date("d", strtotime($data['user']['dob']))) selected @endif value='{{ $i }}'>{{ $i }}</option>
													@endfor
												</select>
												<div class="validation-div val-day"></div>
											</div>
											<div class="col-12 col-md-4 mb-3 mb-md-0">
												<select class="custom-select" name="month" id="month">
													<option value="" selected>Month</option>
													<option value="01" @if(date("m", strtotime($data['user']['dob'])) == '01' ) selected @endif>January</option>
													<option value="02" @if(date("m", strtotime($data['user']['dob'])) == '02' ) selected @endif>February</option>
													<option value="03" @if(date("m", strtotime($data['user']['dob'])) == '03' ) selected @endif>March</option>
													<option value="04" @if(date("m", strtotime($data['user']['dob'])) == '04' ) selected @endif>April</option>
													<option value="05" @if(date("m", strtotime($data['user']['dob'])) == '05' ) selected @endif>May</option>
													<option value="06" @if(date("m", strtotime($data['user']['dob'])) == '06' ) selected @endif>June</option>
													<option value="07" @if(date("m", strtotime($data['user']['dob'])) == '07' ) selected @endif>July</option>
													<option value="08" @if(date("m", strtotime($data['user']['dob'])) == '08' ) selected @endif>August</option>
													<option value="09" @if(date("m", strtotime($data['user']['dob'])) == '09' ) selected @endif>September</option>
													<option value="10" @if(date("m", strtotime($data['user']['dob'])) == '10' ) selected @endif>October</option>
													<option value="11" @if(date("m", strtotime($data['user']['dob'])) == '11' ) selected @endif>November</option>
													<option value="12" @if(date("m", strtotime($data['user']['dob'])) == '12' ) selected @endif>December</option>
												</select>
												<div class="validation-div val-month"></div>
											</div>
											<div class="col-12 col-md-5 mb-3 mb-md-0">
												<select class="custom-select" name="year" id="year">
													<option value="" selected>Year</option>
													@for($i=1980;$i<=2010;$i++)
														<option @if($i==date("Y", strtotime($data['user']['dob']))) selected @endif value='{{ $i }}'>{{ $i }}</option>
													@endfor
												</select>
												<div class="validation-div val-year"></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="Community">Community</label>
										<select class="custom-select" name="community" id="community">
                                            <option value="" selected>Select</option>
											@foreach($options['community'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-community"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(0);" class="btn btn-sign">Submit</button>
								<p class="sign-up-text">By Submit ,you agree to our <a href="{{ url('terms') }}">Terms</a></p>
							</div>
						</div>
					</div>

@section('js')
	<script>
		$("#day option[value='{{ $data->day }}']").attr("selected", true);
		$("#month option[value='{{ $data->month }}']").attr("selected", true);
		$("#year option[value='{{ $data->year }}']").attr("selected", true);
		$("#religion option[value='{{ $data->religion }}']").attr("selected", true);
		$("#community option[value='{{ $data->community }}']").attr("selected", true);
		$("#mother_tongue option[value='{{ $data->mother_tongue }}']").attr("selected", true);
	</script>
@endsection
