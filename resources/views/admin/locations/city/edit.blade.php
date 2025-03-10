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
							<li class="breadcrumb-item"> <a href="{{route('cities.index')}}">Cities</a></li>
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
							<label for="name" class="">State Name</label>
							<input id="name" type="text" value="{{$data->name}}" class="form-control" required>
							<div class="validation-div" id="val-name"></div>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-2">
						<div class="position-relative form-group">
							<label for="state_id">State</label>
							<select class="form-control" id="state_id">
							  <option value="">Select State</option>
							  @foreach($states as $list)
							  <option value="{{$list->id}}" @if($data->state_id == $list->id) selected @endif>{{$list->name}}</option>
							  @endforeach
							</select>
							<div class="validation-div" id="val-state_id"></div>
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
		data.append('name', $('#name').val());
		data.append('state_id', $('#state_id').val());
		data.append('status', $('#status').val());
		var response = adminAjax('{{route("cities.store")}}', data);

        if (response) {
        response.then(function (value) {
            console.log('conditions ara prepare for the data structre');
            if(value.status == '200'){
                console.log('succes response received for the asjsdnnvjsdbnvjk');
                swal.fire({ type: 'success', title: value.message, showConfirmButton: false, timer: 1500 });
                setTimeout(function(){ window.location.href = "{{route('cities.index')}}"; }, 2000)

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
