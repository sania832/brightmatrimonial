					<div id="step-2" class="education-career-step">
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="form-step-title">
									<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
									<h2>Education & Career</h2>
									<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="550">
								</div>
								<ul class="step-list">
									<li></li>
									<li class="active"></li>
									<li></li>
									<li></li>
								</ul>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="highest_qualificatin">Your Highest Qualificatin*</label>
										<select class="custom-select" name="highest_qualification" id="highest_qualification">
											<option value="" selected>Select</option>
											@foreach($options['highest_qualification'] as $key => $value)
												<option value="{{ $key }}" @if($data->highest_qualification == $key) selected @endif>{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-highest_qualificatin"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="company_name">Company Name*</label>
										<input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="{{ $data->company_name }}">
										<div class="validation-div val-company_name"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="YourIncome">Your Income</label>
										<div class="btn-container">
											<label class="switch btn-color-mode-switch">
												<input type="checkbox" name="income_type" id="income_type" value="Yearly">
												<label for="income_type" data-on="Monthly" data-off="Yearly" class="btn-color-mode-switch-inner"></label>
											</label>
										</div>
										<div class="validation-div val-income_type"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="position">Position</label>
										<select class="custom-select" name="position" id="position">
                                            <option value="" selected>Select</option>
											@foreach($options['position'] as $key => $value)
												<option value="{{ $key }}" @if($data->position == $key) selected @endif>{{ $value }}</option>
											@endforeach
										</select>
										<div class="validation-div val-position"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="sign-box">
									<div class="form-group">
										<label for="income">Select Yearly Income*</label>
										<select class="custom-select " name="income" id="income">
											<option value="" selected>Select</option>
											{{-- @foreach($options['income'] as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach --}}
										</select>
										<div class="validation-div val-income"></div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12 mt-5">
								<button type="submit" onclick="updateProfile(2);" class="btn btn-sign mb-0">Continue</button>
							</div>
						</div>
					</div>
@section('js')
<script>
    $(document).ready(function() {
        // Function to fetch income options based on income type
        function fetchIncomeOptions(incomeType) {
            // Construct the URL with the income type parameter
            var url = "{{ url('/') }}/live-data-fetch/" + incomeType;

            // Make AJAX call to fetch data
            $.ajax({
                url: url,
                dataType: "json",
                type: 'GET',
                success: function(data) {
                    console.log('Received Data', data);

                    // Clear existing options in the income dropdown
                    $('#income').empty();

                    // Append new options based on the received data
                    $.each(data, function(index, income) {
                        // Determine if this income option should be selected
                        var selected = (income.id == "{{ $data->income }}") ? 'selected' : '';

                        // Append option with the determined selected attribute
                        $('#income').append('<option value="' + income.id + '" ' + selected + '>' + income.title + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error', error);
                }
            });
        }

        // Get the initial value of incomeType and selectedIncomeId from your data or database
        var initialIncomeType = "{{ $data->income_type }}"; // Replace with the actual initial value
        var selectedIncomeId = "{{ $data->income }}"; // Replace with the actual selected income option ID

        // Set the initial state of the checkbox based on the initial value of incomeType
        $('#income_type').prop('checked', initialIncomeType === 'Monthly');

        // Fetch income options based on the initial value of incomeType
        fetchIncomeOptions(initialIncomeType);

        // Define event handler for income_type checkbox
        $('#income_type').change(function() {
            // Get the income type (Monthly or Yearly)
            var incomeType = $(this).is(':checked') ? 'Monthly' : 'Yearly';

            // Fetch income options based on the selected income type
            fetchIncomeOptions(incomeType);
        });
    });

</script>
@endsection
