					<div id="step-1" class="create-your-profile-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Let's Create Your Profile</h2>
									<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
								</div>
								<ul class="step-list">
									<li class="active"></li>
									<li></li>
									<li></li>
									<li></li>
								</ul>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
                                    <div class="form-group">
										<label for="CreateYourProfile">State You Live In*</label>
										<select class="custom-select " name="state" id="state">
											<option value="" selected>Select</option>
											@foreach($options['state'] as $key => $value)
												<option value="{{ $key }}" @if($data->state == $key) selected @endif>{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-state"></div>
									</div>
                                    <div class="form-group">
										<label for="CreateYourProfile">City You Live In*</label>
										<select class="custom-select " id="city">
                                            @foreach($options['city'] as $key => $value)
												<option value="{{ $key }}" @if($data->city == $key) selected @endif>{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-city"></div>
									</div>
									<div class="form-group">
										<label for="marital_status">Your Marital Status*</label>
										<select class="custom-select " name="marital_status" id="marital_status">
											<option value="" selected>Select</option>
											@foreach($options['marital_status'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-marital_status"></div>
									</div>
									<div class="form-group">
										<label for="height">Hight*</label>
										<select class="custom-select " name="height" id="height">
											<option value="" selected>Select</option>
											@foreach($options['height'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
                                        </select>
										<div class="validation-div val-height"></div>
									</div>
									<div class="form-group">
										<label>Are You Manglik?</label>
										<div class="switch-field">
											<input type="radio" id="manglik-Yes" name="manglik" value="Yes" />
											<label for="manglik-Yes">Yes</label>
											<input type="radio" id="manglik-No" name="manglik" value="No" />
											<label for="manglik-No">No</label>
										</div>
										<div class="validation-div val-manglik"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label>You Live With Your Family?</label>
										<div class="switch-field">
											<input type="radio" id="live_with_family-Yes" name="live_with_family" value="Yes" />
											<label for="live_with_family-Yes">Yes</label>
											<input type="radio" id="live_with_family-No" name="live_with_family" value="No" />
											<label for="live_with_family-No">No</label>
										</div>
										<div class="validation-div val-live_with_family"></div>
									</div>
                                    <div class="form-group">
                                        <label>Your Diet</label>
                                        <div class="switch-field diet-field">
                                            @foreach($options['diet'] as $key => $option)
                                                <input type="radio" id="diet-{{ $key }}" name="diet" value="{{ $key }}" {{ $data->diet == $key ? 'checked' : '' }}>
                                                <label for="diet-{{ $key }}">{{ $option }}</label>
                                            @endforeach
                                        </div>
                                        <div class="validation-div val-diet"></div>
                                    </div>
									<div class="form-group">
										<label>Horoscope Match Is necessary?</label>
										<div class="switch-field">
											<input type="radio" id="horoscope_require-Yes" name="horoscope_require" value="Yes" />
											<label for="horoscope_require-Yes">Yes</label>
											<input type="radio" id="horoscope_require-No" name="horoscope_require" value="No" />
											<label for="horoscope_require-No">No</label>
										</div>
										<div class="validation-div val-horoscope_require"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(1);" class="btn btn-sign mb-0">Continue</button>
							</div>
						</div>
					</div>
@section('js')
    <script>
        $("#city option[value='{{ $data->city }}']").attr("selected", true);
        $("#state option[value='{{ $data->state }}']").attr("selected", true);
        $("#marital_status option[value='{{ $data->marital_status }}']").attr("selected", true);
        $("#height option[value='{{ $data->height }}']").attr("selected", true);
        $("#live_with_family-{{ $data->live_with_family }}").prop("checked", true);
        $("#manglik-{{ $data->manglik }}").prop("checked", true);
        // $("input[name='diet'][value='{{ $data->diet }}']").attr("checked", "checked");
        $("#horoscope_require-{{ $data->horoscope_require }}").prop("checked", true);

        $('#state').change(function() {
        var stateId = $(this).val(); // Get the selected state ID

        // Construct the URL using the state ID
        var url = "{{ url('/') }}/live-data-fetch/" + stateId;

        $.ajax({
            url: url,
            dataType: "json",
            type: 'GET',
            delay: 250,
            success: function(data) {

            // Clear existing options in the city dropdown
            $('#city').empty();

            // Append new options based on the received city data
            $.each(data, function(index, city) {
                $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.log('Error', error); // Print the error message
        }
        });
    });
    </script>
@endsection

