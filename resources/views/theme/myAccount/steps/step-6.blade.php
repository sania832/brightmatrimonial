@section('css')
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2-results__option, .select2-selection__choice__display{
			color: black !important;
		}
	</style>
@endsection
<div id="step-5" class="describe-your-self-step">
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="form-step-title">
				<a class="back-icon" href="{{ url('/complete-profile/'. $step-1) }}"><img src="{{ asset('themeAssets/images/left-arrow.svg') }}" alt=""></a>
				<h2>Likes</h2>
				<img src="images/title-border.svg" alt="" width="550">
			</div>
			<ul class="step-list">
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li class="active"></li>
				<li></li>
				{{-- <li></li> --}}
			</ul>
		</div>
		<div class="col-6">
			<div class="sign-box align-items-start">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label>Favorite Music</label>
							<select multiple="multiple" class="select2-multiple custom-select" name="favorite_music[]" id="favorite_music">
								@foreach($options['favorite_music'] as $key => $value)
									<option value="{{ $key }}" @if($data->favorite_music == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-favorite_music"></div>
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
							<label>Favorite Books</label>
							<select multiple="multiple" class="select2-multiple custom-select" id="favorite_books" name="favorite_books[]">
								@foreach($options['favorite_books'] as $key => $value)
									<option value="{{ $key }}" @if($data->favorite_books == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-favorite_books"></div>
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
							<label>Favorite Movies</label>
							<select multiple="multiple" class="select2-multiple custom-select" id="favorite_movies" name="favorite_movies[]">
								@foreach($options['favorite_movies'] as $key => $value)
									<option value="{{ $key }}" @if($data->favorite_movies == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-favorite_movies"></div>
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
							<label>Favorite Sports</label>
							<select multiple="multiple" class="select2-multiple custom-select" id="favorite_sports" name="favorite_sports[]">
								@foreach($options['favorite_sports'] as $key => $value)
									<option value="{{ $key }}" @if($data->favorite_sports == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-favorite_sports"></div>
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
							<label>Hobbies</label>
							<select multiple="multiple" class="select2-multiple custom-select" id="hobbies" name="hobbies[]">
								@foreach($options['hobbies'] as $key => $value)
									<option value="{{ $key }}" @if($data->hobbies == $key) selected @endif>{{ $value }}</option>
								@endforeach
							</select>
							<div class="validation-div val-hobbies"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 mt-5 mb-4">
			<div class="row">
				<div class="col-4 col-sm-4 mt-5 mb-4"></div>
				<div class="col-4 col-sm-4 mt-5 mb-4">
					<button onclick="updateProfile(6);" class="btn btn-sign w-100 mb-0 verify-btn">Continue</button>
				</div>
				<div class="col-4 col-sm-4 mt-5 mb-4"></div>
			</div>
			<p class="sign-up-text">By Submit ,you agree to our <a href="{{ url('terms') }}">Terms</a></p>
		</div>
	</div>
</div>
@section('js')
	{{-- <script src='https://foliotek.github.io/Croppie/croppie.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script> --}}
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script>
		// $("#manglik_dosha option[value='{{ $data->manglik_dosha }}']").attr("selected", true);
		// $("#horoscope_match option[value='{{ $data->horoscope_match }}']").attr("selected", true);
		// $("#zodiac_sign option[value='{{ $data->zodiac_sign }}']").attr("selected", true);
		$(document).ready(function() {
			$('.select2-multiple').select2({
				placeholder: "Select",
				allowClear: true,
				width: '100%',
				theme: "classic"
			});
		});
	</script>
@endsection