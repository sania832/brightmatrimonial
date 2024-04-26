@extends('layouts.backend.master')
@section('content')
		<div class="app-page-title app-page-title-simple">
			<div class="page-title-wrapper">
				<div class="page-title-heading">
					<div>
						<div class="page-title-head center-elem">
							<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
							<span class="d-inline-block">{{ trans('options.edit') }}</span>
						</div>
					</div>
				</div>
				<div class="page-title-actions">
					<div class="page-title-subheading opacity-10">
						<nav class="" aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a><i aria-hidden="true" class="fa fa-home"></i></a></li>
								<li class="breadcrumb-item"> <a>{{ trans('options.plural.'.$data->type) }}</a></li>
								<li class="active breadcrumb-item" aria-current="page">{{ trans('options.edit') }}</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>

		<!-- CONTENT START -->
		<div class="main-card mb-3 card">
			<div class="card-body">
				<!-- <h5 class="card-title">Grid Rows</h5> -->
				<form class="" action="javascript:void(0);" onsubmit="saveData();">
					<div class="form-row">
						<div class="col-md-6">
							<div class="position-relative form-group">
								<label for="title" class="">{{ trans('options.title') }}</label>
								<input id="title" type="text" class="form-control" placeholder="{{ trans('options.placeholder.title') }}" value="{{$data->title}}">
								<div class="validation-div" id="val-title"></div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group @if(empty($parent)) d-none @endif">
								<label for="parent" class="">{{ trans('options.parent') }}</label>
								<select class="form-control" minlength="2" maxlength="255" id="parent">
								  <option value="">{{trans('common.select')}}</option>
								  @if(!empty($parent))
									@foreach($parent as $list)
								    <option value="{{ $list->id }}" @if($data->parent == $list->id) selected @endif>{{ $list->title }}</option>
									@endforeach
								  @endif
								</select>
								<div class="validation-div" id="val-parent"></div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="slug" class="">{{ trans('options.slug') }}</label>
								<input id="slug" type="text" class="form-control" placeholder="{{ trans('options.placeholder.slug') }}" value="{{$data->slug}}">
								<div class="validation-div" id="val-slug"></div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="status" class="">{{ trans('common.status') }}</label>
								<select  class="form-control" minlength="2" maxlength="255" id="status">
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
		data.append('title', $('#title').val());
		data.append('parent', $('#parent').val());
		data.append('status', $('#status').val());

		var response = adminAjax('{{route("ajax_option_store")}}', data);

        if (response) {
        response.then(function (value) {
            if(value.status == '200'){
                swal.fire({ type: 'success', title: response.message, showConfirmButton: false, timer: 1500 });
			    // setTimeout(function(){ location.reload(); }, 2000);
                // {{ $data->type }}
                setTimeout(function(){
                    window.location.href = "{{ route('optionPage', [$data->type]) }}";
                }, 2000);
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
