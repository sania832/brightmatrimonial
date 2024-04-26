@extends('layouts.backend.master')

@section('content')
	<div class="app-page-title app-page-title-simple">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div>
					<div class="page-title-head center-elem">
						<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
						<span class="d-inline-block">{{ trans('questions.edit') }}</span>
					</div>
				</div>
			</div>
			<div class="page-title-actions">
				<div class="page-title-subheading opacity-10">
					<nav class="" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a><i aria-hidden="true" class="fa fa-home"></i></a></li>
							<li class="breadcrumb-item"> <a>{{ trans('questions.plural') }}</a></li>
							<li class="active breadcrumb-item" aria-current="page">{{ trans('questions.edit') }}</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<!-- CONTENT START -->
	<div class="main-card mb-3 card">
		<div class="card-body">
			<form class="" action="javascript:void(0);" onsubmit="saveData();">
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="slug" class="">{{ trans('question.slug') }}</label>
							<input id="slug" type="text" class="form-control" value="{{ $data->slug }}" placeholder="{{ trans('question.placeholder.slug') }}">
							<div class="validation-div" id="val-slug"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="man_question" class="">{{ trans('question.man_question') }}</label>
							<input id="man_question" type="text" class="form-control" value="{{ $data->Male }}" placeholder="{{ trans('question.placeholder.man_question') }}">
							<div class="validation-div" id="val-man_question"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="women_question" class="">{{ trans('question.women_question') }}</label>
							<input id="women_question" type="text" class="form-control" value="{{ $data->Female }}" placeholder="{{ trans('question.placeholder.women_question') }}">
							<div class="validation-div" id="val-women_question"></div>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-5">
						<h5>Men Options</h5>
						<div class="position-relative form-group">
							@if($options->count() > 0)
								@foreach($options as $list)
								{{$list->type}})<input id="man_option_{{$list->type}}" type="text" class="form-control" value="{{$list->Male}}">
									<div class="validation-div" id="val-man_option_{{$list->type}}"></div>
								@endforeach
							@else
								a) <input id="man_option_a" type="text" class="form-control">
								<div class="validation-div" id="val-man_option_a"></div>
								b) <input id="man_option_b" type="text" class="form-control">
								<div class="validation-div" id="val-man_option_b"></div>
								c) <input id="man_option_c" type="text" class="form-control">
								<div class="validation-div" id="val-man_option_c"></div>
								d) <input id="man_option_d" type="text" class="form-control">
								<div class="validation-div" id="val-man_option_d"></div>
							@endif
						</div>
					</div>
					<div class="col-md-1">
					</div>
					<div class="col-md-5">
						<h5>Women Options</h5>
						<div class="position-relative form-group">
							@if($options->count() > 0)
								@foreach($options as $list)
								{{$list->type}})<input id="women_option_{{$list->type}}" type="text" class="form-control" value="{{$list->Female}}">
									<div class="validation-div" id="val-women_option_{{$list->type}}"></div>
								@endforeach
							@else
								a) <input id="women_option_a" type="text" class="form-control">
								<div class="validation-div" id="val-women_option_a"></div>
								b) <input id="women_option_b" type="text" class="form-control">
								<div class="validation-div" id="val-women_option_b"></div>
								c) <input id="women_option_c" type="text" class="form-control">
								<div class="validation-div" id="val-women_option_c"></div>
								d) <input id="women_option_d" type="text" class="form-control">
								<div class="validation-div" id="val-women_option_d"></div>
							@endif
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="women_question" class="">{{ trans('common.status') }}</label>
							<select  class="form-control" minlength="2" maxlength="255" id="status">
							  <option value="active" @if($data->status == "active") selected @endif >{{trans('common.active')}}</option>
							  <option value="inactive" @if($data->status == "inactive") selected @endif >{{trans('common.inactive')}}</option>
							</select>
						</div>
					</div>
				</div>
				<button class="mt-2 btn btn-primary">{{ trans('common.submit') }}</button>
			</form>
		</div>
	</div>
	<!-- CONTENT OVER -->
@endsection


@section('js')
	<script>
		// CREATE
  	function saveData(){
		var data = new FormData();
		data.append('item_id', '{{$data->id}}');
		data.append('slug', $('#slug').val());
		data.append('man_question', $('#man_question').val());
		data.append('women_question', $('#women_question').val());
		data.append('status', $('#status').val());

		data.append('man_option_a', $('#man_option_a').val());
		data.append('man_option_b', $('#man_option_b').val());
		data.append('man_option_c', $('#man_option_c').val());
		data.append('man_option_d', $('#man_option_d').val());

		data.append('women_option_a', $('#women_option_a').val());
		data.append('women_option_b', $('#women_option_b').val());
		data.append('women_option_c', $('#women_option_c').val());
		data.append('women_option_d', $('#women_option_d').val());

		var response = adminAjax('{{route("questions.store")}}', data);
		if (response) {
        response.then(function (value) {
            console.log('conditions ara prepare for the data structre');
            if(value.status == '200'){
                console.log('succes response received for the asjsdnnvjsdbnvjk');
                swal.fire({ type: 'success', title: value.message, showConfirmButton: false, timer: 1500 });
                setTimeout(function(){ window.location.href = "{{route('questions.index')}}"; }, 2000)

            }else if(value.status == '422'){
                $('.validation-div').text('');
                $.each(value.error, function( index, field ) {
                    $('#val-'+index).text(field);
                });

            } else if(value.status == '201'){
                swal.fire({title: value.message,type: 'error'});
            }
  	    });
    }
  	}
	</script>
@endsection
