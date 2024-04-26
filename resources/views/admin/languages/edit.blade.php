@extends('layouts.backend.master')

@section('content')
	<div class="app-page-title app-page-title-simple">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div>
					<div class="page-title-head center-elem">
						<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
						<span class="d-inline-block">Edit</span>
					</div>
				</div>
			</div>
			<div class="page-title-actions">
				<div class="page-title-subheading opacity-10">
					<nav class="" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i aria-hidden="true" class="fa fa-home"></i></a></li>
							<li class="breadcrumb-item"> <a href="{{route('languages.index')}}">Areas</a></li>
							<li class="active breadcrumb-item" aria-current="page">Edit</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<!-- CONTENT START -->
	<div class="main-card mb-3 card">
		<div class="card-body">
			<form action="javascript:void(0);" onsubmit="saveData();">
				<div class="form-row">
					<div class="col-md-4">
						<div class="position-relative form-group">
							<label for="title">Title</label>
							<input id="title" type="text" value="{{$data->title}}" class="form-control">
							<div class="validation-div" id="val-title"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="code">Code</label>
							<input id="code" type="text" value="{{$data->code}}" class="form-control">
							<div class="validation-div" id="val-code"></div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="slug">Slug</label>
							<input id="slug" type="text" value="{{$data->slug}}" class="form-control">
							<div class="validation-div" id="val-slug"></div>
						</div>
					</div>
				</div>

				<hr>
				<div class="form-row">
					<div class="col-md-2">
						<div class="form-group">
							<select class="form-control" name="status" id="status" required>
								<option value="active"
								@if($data->status == 'active') selected @endif>
									{{trans('common.active')}}
								</option>
								<option value="inactive"
								@if($data->status == 'inactive') selected @endif>
									{{trans('common.inactive')}}
								</option>
							</select>
							<div class="validation-div" id="val-status"></div>
						</div>
					</div>
				</div>
				<button class="mt-2 btn btn-primary">Update</button>
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
		data.append('title', $('#title').val());
		data.append('code', $('#code').val());
		data.append('slug', $('#slug').val());
		data.append('status', $('#status').val());
		var response = adminAjax('{{route("languages.store")}}', data);

        if (response) {
        response.then(function (value) {
            if(value.status == '200'){
                swal.fire({ type: 'success', title: response.message, showConfirmButton: false, timer: 1500 });
			    setTimeout(function(){ window.location.href = "{{route('languages.index')}}"; }, 2000)
            }else if(value.status == '422'){
                $('.validation-div').text('');
                $.each(value.error, function( index, value ) {
                    $('#val-'+index).text(value);
                });
            } else if(value.status == '201'){
                swal.fire({title: value.message,type: 'error'});
            }
  	    });
    }
	}
</script>
@endsection
