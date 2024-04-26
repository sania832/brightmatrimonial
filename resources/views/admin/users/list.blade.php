@extends('layouts.backend.master')

@section('filter')
		<!-- FILTERS -->
		<div class="modal fade" id="filterBox" tabindex="-1" role="dialog" aria-labelledby="filterBoxTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="filterTitle">{{trans('common.filters')}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Page</span>
									</div>
									<input id="page" value="1" placeholder="Ex: 0 or 100" step="1" type="number" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Count</span>
									</div>
									<input id="count" value="10" placeholder="Ex: 0 or 100" step="1" type="number" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Title</span>
									</div>
									<input id="search" placeholder="Type to search" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br>
								<h5 class="card-title">Status</h5>
								<div class="position-relative form-group">
									<div>
										<div class="custom-radio custom-control">
											<input type="radio" id="active" value="active" name="statusRadio" class="custom-control-input">
											<label class="custom-control-label" for="active">Active</label>
										</div>
										<div class="custom-radio custom-control">
											<input type="radio" id="inactive" value="inactive" name="statusRadio" class="custom-control-input">
											<label class="custom-control-label" for="inactive">Inactive</label>
										</div>
										<div class="custom-radio custom-control">
											<input type="radio" id="all" value="all" name="statusRadio" class="custom-control-input" checked>
											<label class="custom-control-label" for="all">All</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" onclick="getData();" data-dismiss="modal">Apply</button>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('content')
		<div class="app-page-title app-page-title-simple">
			<div class="page-title-wrapper">
				<div class="page-title-heading">
					<div>
						<div class="page-title-head center-elem">
							<span class="d-inline-block pr-2"><i class="lnr-apartment opacity-6"></i></span>
							<span class="d-inline-block">{{ trans('users.heading') }}</span>
						</div>
					</div>
				</div>
				<div class="page-title-actions">
					<div class="page-title-subheading opacity-10">
						<nav class="" aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a><i aria-hidden="true" class="fa fa-home"></i></a></li>
								<li class="breadcrumb-item"> <a>{{ trans('users.plural') }}</a></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<!-- CONTENT START -->
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">{{trans('users.users_list')}}</div>
				<div class="btn-actions-pane-right text-capitalize">
					{{-- <a class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm" href="{{ route('users.create') }}" > {{trans('common.add_new')}} </a> --}}
				</div>
			</div>
			<div class="card-body">
				<h5 class="card-title"></h5>
				<div class="table-responsive">
					<table class="mb-0 table table-striped">
						<thead>
							<tr>
							 <th>#</th>
							 <th>{{ trans('users.title') }}</th>
							 <th>{{ trans('users.email') }}</th>
							 <th>{{ trans('users.user_type') }}</th>
							 <th>{{ trans('users.registered_on') }}</th>
							 <th>{{ trans('common.status') }}</th>
							 <th>{{ trans('common.profile_status') }}</th>
							 <th>{{ trans('common.action') }}</th>
							</tr>
						</thead>
						<tbody id="data-list"></tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- CONTENT OVER -->
@endsection

@section('js')
<script>
	$(document).ready(function(e) {
		var page = $('#filterBox #page').val();
		getData(page);

		$('.next-btn').click(function() {
			page = Number($('#filterBox #page').val()) + 1;
			getData(page);
		});

		$('.previous-btn').click(function() {
			page = Number($('#filterBox #page').val()) - 1;
			if(page == 0){ return false;}
			getData(page);
		});

		// Change User Status
		$(document).on('change','.change_user_status',function(){
			var data = new FormData();
			data.append('status', $(this).val());
			data.append('id', $(this).attr('id'));
			var response = adminAjax('{{route("change_user_status")}}', data);

            if (response) {
            response.then(function (value) {
                if(value.status == '200'){
                    swal.fire({ type: 'success', title: response.message, showConfirmButton: false, timer: 1500 });
                    //setTimeout(function(){ location.reload(); }, 2000)
                }
                }).catch(function (error) {
                    console.log('An error occurred:', error);
                });
            }
		});

		// Change Profile Stats
		$(document).on('change','.change_approve_status',function(){
			var data = new FormData();
			data.append('status', $(this).val());
			data.append('id', $(this).attr('id'));
			var response = adminAjax('{{route("change_approve_status")}}', data);

            if (response) {
            response.then(function (value) {
                if(value.status == '200'){
                    swal.fire({ type: 'success', title: response.message, showConfirmButton: false, timer: 1500 });
                    //setTimeout(function(){ location.reload(); }, 2000)
                }
                }).catch(function (error) {
                    console.log('An error occurred:', error);
                });
            }
		});

	});
	// GET LIST
	function getData(page = 1){
		var data = new FormData();
		data.append('page', page);
		data.append('count', $('#filterBox #count').val());
		data.append('search', $('#filterBox #search').val());
		data.append('status', $('input[name="statusRadio"]:checked').val());

		var response = adminAjax('{{route("users_list")}}', data);

        if (response) {
            response.then(function (value) {
            if(value.status == '200'){
                console.log('status 200 receiverd');
                console.log(value);
                var htmlData = '';
			$('#data-list').empty();
			if(value.data.length > 0){
				$('#filterBox #page').val(page);
				$.each(value.data, function( index, value ) {

                    var datePart = value.created_at.substring(0, 10); // Extract date part
                    var timePart = value.created_at.substring(11, 19); // Extract time part

                    // var created_at = datePart + ' ' + timePart;

					// var dteSplit = value.created_at.split("-");
					// var yr = dteSplit[0];
					// var month = dteSplit[1];
					// var day = dteSplit[2].split(' ')[0];
				    var registered_date = datePart + ' ' + timePart;
				    htmlData+= '<tr>'+
						'<th scope="row">'+ value.id +'</th>'+
						'<td>'+ value.name +'</td>'+
						'<td>'+ value.email +'</td>'+
						'<td>'+ value.user_type +'</td>'+
						'<td>'+ registered_date +'</td>'+
						'<td>'+ value.user_status +'</td>'+
						'<td>'+ value.profile_status +'</td>'+
						'<td>'+ value.action +'</td>'+
					'</tr>';
				})
			}
			$('#data-list').html(htmlData);
		}
            }).catch(function (error) {
                console.log('An error occurred:', error);
            });
		}
	}

</script>
@endsection
