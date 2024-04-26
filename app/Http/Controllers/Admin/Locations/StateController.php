<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Models\Helpers\CommonHelper;
use Illuminate\Support\Facades\Log;
use App,Validator,Auth,DB,Storage;

class StateController extends CommonController
{
    use CommonHelper;

	// List Page
    public function index() {
        return view('admin.locations.state.list');
	}

	// CREATE
	public function create(){

		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		$countries 	= Country::where('status', 'active')->get();
		return view('admin.locations.state.add', compact('countries'));
	}

	// EDIT
	public function edit($id = null){
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}
		$data 		= State::find($id);
		$countries 	= Country::where('status', 'active')->get();

		return view('admin.locations.state.edit', compact('data', 'countries'));
	}

    // LIST
	public function ajax_list(Request $request){
		$page     = $request->page ?? '1';
		$count    = $request->count ?? '10';

		if ($page <= 0){ $page = 1; }
		$start  = $count * ($page - 1);

		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		try{
			// GET LIST
			$query = State::query();

			if(!empty($request->status) && $request->status != 'all'){
				$query->where('status', $request->status);
			}

			$data  = $query->orderBy('id', 'DESC')->offset($start)->limit($count)->get();
            // Log::info($data);
			if($data){
				foreach($data as $key=> $list){
                    Log::info($key);
					$data[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("states.edit",$list->id) .'"><i class="fa fa-eye"></i></a>
											<button class="border-0 btn-transition btn btn-outline-danger" onclick="deleteThis('. $list->id .')"><i class="fa fa-trash-alt"></i></button>
											</div>';

					$status_array = ['active'=>'', 'inactive'=>''];
					if($list->status == 'active') { $status_array['active'] = 'selected'; }
					if($list->status == 'inactive') { $status_array['inactive'] = 'selected'; }
					$data[$key]->status = "<select class='form-control status' id='$list->id'>
										<option value='active' 	". $status_array['active'] .">Active</option>
										<option value='inactive'". $status_array['inactive'] .">Inactive</option>
									</select>";

                    $data[$key]->country_name = Country::where('id',$list->country_id)->pluck('country_name');
				}
				return $this->sendResponse(trans('common.data_found_success'),$data);
			}
			return $this->sendResponse(trans('common.data_found_empty'),[]);
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	// STORE
	public function store(Request $request){

		$validator = Validator::make($request->all(), [
			'name'			=> 'required|min:3|max:99',
			'country_id'	=> 'required|min:1|max:21',
		]);
		if($validator->fails()){
			return $this->ajaxValidationError(trans('common.error'),$validator->errors());
		}

		$user = Auth()->user();
 		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		DB::beginTransaction();
		try{

			$data = [
				'name' 			=> $request->name,
				'country_id'	=> $request->country_id,
				'status' 		=> $request->status
			];

			if(!empty($request->item_id)){
				if(State::where('id',$request->item_id)->update($data)){
					DB::commit();
					return $this->sendResponse(trans('common.updated_success'),[]);
				}
			}else{
				if(State::create($data)){
					DB::commit();
					return $this->sendResponse('State added successfully',[]);
				}
			}
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	/**
	* Change Status.
	* @return void
	*/
	public function change_status(Request $request){
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
			$this->ajaxError(trans('common.error'),$validator->errors());
		}

		DB::beginTransaction();
		try {
			$query = State::where('id',$request->item_id)->update(['status'=>$request->status]);
			if($query){
			  DB::commit();
			  return $this->sendResponse(trans('common.updated_success'),['status'=>'success']);
			}else{
			  DB::rollback();
			  return $this->sendResponse(trans('common.updated_error'),['status'=>'error']);
			}

		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	// DESTROY
	public function destroy(Request $request){
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
			$this->ajaxError(trans('common.error'),$validator->errors());
		}

		try{
			// DELETE
			$query = State::where(['id'=>$request->item_id])->delete();
			if($query){
				return $this->sendResponse(trans('common.delete_success'),[]);
			}
			return $this->sendResponse(trans('common.delete_error'),[]);
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}
}
