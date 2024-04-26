<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use App\Models\Helpers\CommonHelper;
use App,Validator,Auth,DB,Storage;

class CityController extends CommonController
{
    use CommonHelper;


 	// List Page
    public function index() {
        return view('admin.locations.city.list');
	}

	// CREATE
	public function create(){

		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		$states	= State::where('status', 'active')->get();
		return view('admin.locations.city.add', compact('states'));
	}

	// EDIT
	public function edit($id = null){
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}
		$data 		= City::find($id);
		$states 	= State::where('status', 'active')->get();

		return view('admin.locations.city.edit', compact('data', 'states'));
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
			$query = City::query();

			if(!empty($request->status) && $request->status != 'all'){
				$query->where('status', $request->status);
			}

			$data  = $query->orderBy('id', 'DESC')->offset($start)->limit($count)->get();
			if($data){
				foreach($data as $key=> $list){
					$data[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("cities.edit",$list->id) .'"><i class="fa fa-eye"></i></a>
											<button class="border-0 btn-transition btn btn-outline-danger" onclick="deleteThis('. $list->id .')"><i class="fa fa-trash-alt"></i></button>
											</div>';

					$status_array = ['active'=>'', 'inactive'=>''];
					if($list->status == 'active') { $status_array['active'] = 'selected'; }
					if($list->status == 'inactive') { $status_array['inactive'] = 'selected'; }
					$data[$key]->status = "<select class='form-control status' id='$list->id'>
										<option value='active' 	". $status_array['active'] .">Active</option>
										<option value='inactive'". $status_array['inactive'] .">Inactive</option>
									</select>";
                    $data[$key]->state_name = State::where('id',$list->state_id)->pluck('name');
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
			'name'		=> 'required|min:3|max:99',
			'state_id'	=> 'required|min:1|max:21',
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
				'name'		=> $request->name,
				'state_id'	=> $request->state_id,
				'status'	=> $request->status
			];

			if(!empty($request->item_id)){
				if(City::where('id',$request->item_id)->update($data)){
					DB::commit();
					return $this->sendResponse(trans('common.updated_success'),[]);
				}
			}else{
				if(City::create($data)){
					DB::commit();
					return $this->sendResponse('City added successfully',[]);
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
			$query = City::where('id',$request->item_id)->update(['status'=>$request->status]);
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
			$query = City::where(['id'=>$request->item_id])->delete();
			if($query){
				return $this->sendResponse(trans('common.delete_success'),[]);
			}
			return $this->sendResponse(trans('common.delete_error'),[]);
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}
}
