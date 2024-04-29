@extends('layouts.theme.master')

@section('content')
		<main>
		<section class="match-banner">
			<img class="match-banner-img" src="{{ asset('themeAssets/images/hero-banner.jpg') }}" alt="">
		</section>
		<section class="match-list common-padding common-bg-pattern">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="match-search">
							<form action="javascript:void(0);" onsubmit="getData(1, 'search-list')">
								<div class="row">
									<div class="col-12 col-sm-12">
										<div class="form-step-title">
											<h2>Search Profile</h2>
											<img src="{{ asset('themeAssets/images/title-border.svg') }}" alt="" width="450">
										</div>
									</div>
									<div class="col-12 col-lg-6">
										<div class="sign-box">
											<div class="row">
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<label for="height">Height</label>
														<select class="custom-select" id="height">
															<option value="" selected>Select</option>
                                                            @foreach($options['height'] as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
														</select>
													</div>
												</div>
												<div class="col-sm-12 col-lg-6">
													<div class="form-group">
														<label for="age">Age</label>
														<div class="row">
															<div class="col-12 col-md-6 mb-3 mb-md-0">
																<select class="custom-select" id="age_from">
																	<option value="" selected>From</option>
																	@for ($i = 1; $i < 46; $i++)
																		<option value="{{ $i }}">{{ $i }}</option>
																	@endfor
																</select>
															</div>
															<div class="col-12 col-md-6">
																<select class="custom-select " id="age_to">
																	<option value="" selected>To</option>
																	@for ($i = 1; $i < 66; $i++)
																		<option value="{{ $i }}">{{ $i }}</option>
																	@endfor
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-6">
										<div class="sign-box">
											<div class="row">
												<div class="col-12 col-md-6 mb-3 mb-md-0">
													<div class="form-group">
														<label for="religion">Religion</label>
														<select class="custom-select" id="religion">
															<option value="" selected>Select</option>
                                                            @foreach($options['religion'] as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
														</select>
													</div>
												</div>
												<div class="col-12 col-md-6 mb-3 mb-md-0">
													<div class="form-group">
														<label for="cast">Cast</label>
														<select class="custom-select" id="cast">
															<option value="" selected>Select</option>
                                                            @foreach($options['cast'] as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-6">
										<div class="sign-box">
											<div class="row">
												<div class="col-12 col-md-6 mb-3 mb-md-0">
													<div class="form-group">
														<label for="marital_status">Maritial Status</label>
														<select class="custom-select" id="marital_status">
															<option value="" selected>Select</option>
                                                            @foreach($options['marital_status'] as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
														</select>
													</div>
												</div>
                                                <div class="col-12 col-md-6 mb-3 mb-md-0">
													<div class="form-group">
														<label for="maritial-status">Income</label>
														<div class="row">
															<div class="col-12 col-md-6 mb-3 mb-md-0">
																<select class="custom-select" id="income_from">
																	<option value="" selected>Select</option>
                                                                    @foreach($options['income'] as $key => $value)
                                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                                    @endforeach
																</select>
															</div>
															<div class="col-12 col-md-6">
																<select class="custom-select" id="income_to">
																	<option value="" selected>Select</option>
                                                                    @foreach($options['income'] as $key => $value)
                                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                                    @endforeach
																</select>
															</div>
														</div>
													</div>
												</div>
												{{-- <div class="col-12 col-md-6 mb-3 mb-md-0 ">
													<div class="form-group">
														<label for="relationship-type">Relationship Type</label>
														<select class="custom-select" id="relationship_type">
															<option value="" selected>Select</option>
                                                            @foreach($options['relationship_type'] as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
														</select>
													</div>
												</div> --}}
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-6">
										<div class="sign-box">
											<div class="row">

												{{-- <div class="col-12 col-md-6 mb-3 mb-md-0">
													<div class="form-group">
														<label for="sexual-orientation">Sexual Orientation</label>
														<select class="custom-select" id="sexual_orientation">
															<option value="" selected>Select</option>
                                                                @foreach($options['sexual_orientation'] as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                @endforeach
														</select>
													</div>
												</div> --}}
											</div>
										</div>
									</div>

									<div class="col-12 col-sm-12">
										<button type="submit" class="btn btn-sign">Search</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-12">
						<ul id="search-list"></ul>
					</div>
				</div>
			</div>
		</section>
	</main>
    <!-- /main -->
@endsection

@section('js')
<script>
	$(document).ready(function(e) {
		getData(1, 'search-list');
	});
	// GET LIST
	function getData(page = 1, section = ''){
		var data = new FormData();
		data.append('page', page);
		data.append('count', 10);
		data.append('section', section);

         // Get selected values from form fields
        var height = $('#height').val();
        var from_age = $('#age_from').val();
        var to_age = $('#age_to').val();
        var religion = $('#religion').val();
        var cast = $('#cast').val();
        var marital_status = $('#marital_status').val();
        var relationship_type = $('#relationship_type').val();
        var income_from = $('#income_from').val();
        var income_to = $('#income_to').val();
        var sexual_orientation = $('#sexual_orientation').val();

        data.append('height', height);
        data.append('age_from', from_age);
        data.append('age_to', to_age);
        data.append('religion', religion);
        data.append('cast', cast)
        data.append('marital_status', marital_status)
        data.append('relationship_type', relationship_type)
        data.append('income_from', income_from)
        data.append('income_to', income_to)
        data.append('sexual_orientation', sexual_orientation)

		var response = runAjax(SITE_URL +'/get_matches', data);

        if (response) { // check if the response is defined
        response.then(function (value) { // process the response using a Promise
            if(value.status == '200'){
			var htmlData = '';
			$('#search-list').empty();
			if(value.data.length > 0){
				$.each(value.data, function(index, value) {
                    htmlData += '<li>' +
                        '<a href="{{ url("profile")}}/' + value.id + '" class="match-item">' +
                            '<div class="col-12 col-md-2 match-img-container">' +
                                '<img class="match-img" src="' + (value.image ? value.image : '/images/default_image.webp') + '" alt="' + (value.name ? value.name : '') + '" style="width: 100px; height: 100px; object-fit: cover;">' +
                            '</div>' +
                            '<div class="match-info-container col-12 col-md-10">' +
                                '<div class="match-info">' +
                                    '<h2>' + (value.name ? value.name : '') + '</h2>' +
                                    '<p class="match-id">Profile ID : BG' + (value.id ? value.id : '') + '</p>' +
                                    '<img class="match-info-img" src="{{ asset("themeAssets/images/title-border.svg") }}" alt="">' +
                                    '<div class="row">' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.age + '</p></div>' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.city + '</p></div>' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.height + '</p></div>' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.state + '</p></div>' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.marital_status + '</p></div>' +
                                        '<div class="col-sm-12 col-md-6"><p>' + value.income + '</p></div>' +
                                        // '<div class="col-sm-12"><p>' + value.occupation + '</p></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                    '</li>';
                });
			}else {
                // If no records found, display a message
                htmlData = '<p class="text-center p-2 rounded" style="background-color: rgba(211, 211, 211, 1); color: black;" >No records found.</p>';
            }
			$('#search-list').html(htmlData);
		}
    })
    }
	}
</script>
@endsection
