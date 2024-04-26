@extends('layouts.backend.master')

@section('content')
	<div class="app-page-title app-page-title-simple">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div>
					<div class="page-title-head center-elem">
						<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
						<span class="d-inline-block">{{ trans('user.edit') }}</span>
					</div>
				</div>
			</div>
			<div class="page-title-actions">
				<div class="page-title-subheading opacity-10">
					<nav class="" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a><i aria-hidden="true" class="fa fa-home"></i></a></li>
							<li class="breadcrumb-item"> <a>{{ trans('user.plural') }}</a></li>
							<li class="active breadcrumb-item" aria-current="page">{{ trans('user.edit') }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<!-- CONTENT START -->
	<div class="main-card mb-3 card">
		<div class="card-body">
			<h5 class="card-title">{{trans('user.details')}}</h5>
			<form class="" action="javascript:void(0);" onsubmit="updateUser()">
				<div class="form-row">
					@if($data['profile_image'])
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="document" class="">{{ trans('users.profile_picture') }}</label><br>
							<img width="122" height="122" class="rounded-circle" src="{{ asset(''. $data['profile_image']) }}">
						</div>
					</div>
					@endif
					@if($data['profile_image'])
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="document" class="">{{ trans('users.cover_image') }}</label><br>
							<img style="max-height:122px;" src="{{ asset(''. $data['cover_image']) }}">
						</div>
					</div>
					@endif
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="first_name" class="">{{ trans('users.first_name') }}</label>
							<input id="first_name" value="{{$data['first_name']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-first_name"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="last_name" class="">{{ trans('users.last_name') }}</label>
							<input id="last_name" value="{{$data['last_name']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-last_name"></div>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="email" class="">{{ trans('users.email') }}</label>
							<input id="email" value="{{$data['email']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-email"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="phone_number" class="">{{ trans('users.phone_number') }}</label>
							<input id="phone_number" value="{{$data['phone_number']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-phone_number"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="dob" class="">{{ trans('users.dob') }}</label>
							<input id="dob" value="{{$data['dob']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-dob"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="user_type" class="">{{ trans('users.user_type') }}</label>
							<input id="user_type" value="{{$data['user_type']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-user_type"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="status" class="">{{ trans('common.status') }}</label>
							<input id="status" value="{{$data['status']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-status"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="created_at" class="">{{ trans('users.created_at') }}</label>
							<input id="created_at" value="{{$data['created_at']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-created_at"></div>
						</div>
					</div>
				</div>
				{{-- <button class="mt-2 btn btn-primary">{{ trans('common.update') }}</button> --}}
			</form>
		</div>
	</div>

	@if($user_bio)
	<div class="main-card mb-3 card">
		<div class="card-body">
			<h5 class="card-title">{{trans('user_bio.profile_details')}}</h5>
			<form class="" action="javascript:void(0);" onsubmit="updateUser()">
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="religion" class="">{{ trans('user_bio.religion') }}</label>
							<input id="religion" value="{{ $user_details['religion'] }}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-religion"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="community" class="">{{ trans('user_bio.community') }}</label>
							<input id="community" value="{{$user_details['community']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-community"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="mother_tongue" class="">{{ trans('user_bio.mother_tongue') }}</label>
							<input id="mother_tongue" value="{{$user_details['mother_tounge']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-mother_tongue"></div>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="city" class="">{{ trans('user_bio.city') }}</label>
							<input id="city" value="{{$user_details['city']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-city"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="live_with_family" class="">{{ trans('user_bio.live_with_family') }}</label>
							<input id="live_with_family" value="{{$user_bio['live_with_family']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-live_with_family"></div>
						</div>
					</div>
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-3">
						<div class="position-relative form-group">
							<label for="marital_status" class="">{{ trans('user_bio.marital_status') }}</label>
							<input id="marital_status" value="{{$user_details['marital_status']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-marital_status"></div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="position-relative form-group">
							<label for="diet" class="">{{ trans('user_bio.diet') }}</label>
							<input id="diet" value="{{$user_bio['diet']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-diet"></div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="position-relative form-group">
							<label for="height" class="">{{ trans('user_bio.height') }}</label>
							<input id="height" value="{{$user_details['height']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-height"></div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="position-relative form-group">
							<label for="position" class="">{{ trans('user_bio.position') }}</label>
							<input id="position" value="{{$user_details['position']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-position"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="cast" class="">{{ trans('user_bio.cast') }}</label>
							<input id="cast" value="{{$user_details['cast']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-cast"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="sub_cast" class="">{{ trans('user_bio.sub_cast') }}</label>
							<input id="sub_cast" value="{{$user_details['sub_cast']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-sub_cast"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="family_type" class="">{{ trans('user_bio.family_type') }}</label>
							<input id="family_type" value="{{$user_details['family_type']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-family_type"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="father_occupation" class="">{{ trans('user_bio.father_occupation') }}</label>
							<input id="father_occupation" value="{{$user_details['father_occupation']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-father_occupation"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="brother" class="">{{ trans('user_bio.brother') }}</label>
							<input id="brother" value="{{$user_bio['brother']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-brother"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="sister" class="">{{ trans('user_bio.sister') }}</label>
							<input id="sister" value="{{$user_bio['sister']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-sister"></div>
						</div>
					</div>
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="family_living_in" class="">{{ trans('user_bio.family_living_in') }}</label>
							<input id="family_living_in" value="{{$user_details['family_living_in']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-family_living_in"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="family_bio" class="">{{ trans('user_bio.family_bio') }}</label>
							<input id="family_bio" value="{{$user_bio['family_bio']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-family_bio"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="family_address" class="">{{ trans('user_bio.family_address') }}</label>
							<input id="family_address" value="{{$user_bio['family_address']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-family_address"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="family_contact_no" class="">{{ trans('user_bio.family_contact_no') }}</label>
							<input id="family_contact_no" value="{{$user_bio['family_contact_no']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-family_contact_no"></div>
						</div>
					</div>
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="about" class="">{{ trans('user_bio.about') }}</label>
							<input id="about" value="{{$user_bio['about']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-about"></div>
						</div>
					</div>
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="document_type" class="">{{ trans('user_bio.document_type') }}</label>
							<input id="document_type" value="{{$user_details['document_type']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-document_type"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="document_number" class="">{{ trans('user_bio.document_number') }}</label>
							<input id="document_number" value="{{$user_bio['document_number']}}" type="text" class="form-control" disabled>
							<div class="validation-div" id="val-document_number"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="document" class="">{{ trans('user_bio.document') }}</label>
							<img style="max-height:382px;" src="{{ asset(''. $user_bio['document']) }}">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif
@endsection

@section('js')
	<script>
    function updateUser() {
        var data = new FormData();
        data.append('first_name', $('#first_name').val());
        data.append('email', $('#email').val());
        data.append('last_name', $('#last_name').val());
        data.append('dob', $('#dob').val());

        var response = adminAjax('{{route("updateUser")}}', data);
            if (response) {
            response.then(function (value) {
                if(value.status == '200'){
                    swal.fire({
                        type: 'success',
                        title: value.message,
                        showConfirmButton: false,
                        timer: 50000
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 2000)
                }else if(value.status == '422'){
                    $('.validation-div').text('');
                    $.each(value.error, function(index, value) {
                        $('#val-' + index).text(value);
                    });

                } else if(value.status == '201'){
                    swal.fire({
                        title: value.message,
                        type: 'error'
                    });
                }
            });
        }
    }
	</script>
@endsection
