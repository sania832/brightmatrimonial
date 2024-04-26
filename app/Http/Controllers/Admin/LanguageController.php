<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Helpers\CommonHelper;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Language;
use Illuminate\Support\Facades\Log;

class LanguageController extends CommonController
{
	use CommonHelper;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
 		$this->middleware('auth');
		//$this->middleware('permission:category-list', ['only' => ['index','show']]);
		//$this->middleware('permission:category-create', ['only' => ['create','store']]);
		//$this->middleware('permission:category-edit', ['only' => ['edit','update']]);
	}

	// ADD NEW
	public function index(){
		return view('admin.languages.list');
	}

	// CREATE
	public function create(){

		return view('admin.languages.add');
	}

	// EDIT
	public function edit($id = null){
		$data 	 = Language::find($id);
		return view('admin.languages.edit',compact('data'));
	}

	public function ajax($id = null){
		try{
			// GET LIST
			$query = Language::orderBy('id','DESC')->get();
			if($query){
				foreach($query as $key=> $list){
					$query[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("languages.edit",$list->id) .'"><i class="fa fa-eye"></i></a>
											<button class="border-0 btn-transition btn btn-outline-danger" onclick="deleteThis('. $list->id .')"><i class="fa fa-trash-alt"></i></button>
											</div>';

					$status_array = ['active'=>'', 'inactive'=>''];
					if($list->status == 'active') { $status_array['active'] = 'selected'; }
					if($list->status == 'inactive') { $status_array['inactive'] = 'selected'; }
					$status = "<select class='form-control change_status' id='$list->id'>
										<option value='active' 	". $status_array['active'] .">Active</option>
										<option value='inactive'". $status_array['inactive'] .">Inactive</option>
									</select>";

					$query[$key]->status = $status;
				}
				return $this->sendResponse( trans('common.data_found_success'),$query);
			}
			 return $this->sendResponse(trans('common.data_found_empty'),[]);

		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}

	}

	// STORE
	public function store(Request $request){

		$validator = Validator::make($request->all(), [
			'title'		=> 'required|min:1|max:99',
			'code'		=> 'required|min:1|max:99',
			'slug'		=> 'required|min:1|max:99',
			'status'	=> 'required|min:1|max:99',
		]);
		if($validator->fails()){
			return $this->ajaxValidationError(trans('common.error'),$validator->errors());
		}

		$user = Auth()->user();
 		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		if($request->item_id){
			$validator = Validator::make($request->all(), [
				'item_id' => 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'),$validator->errors());
			}
		}

		DB::beginTransaction();
		try{
			$data = [
				'title'		=> $request->title,
				'code'		=> $request->code,
				'slug'		=> $request->slug,
				'status'	=> $request->status,
			];

			if($request->item_id){
				// UPDATE
				$details  =  Language::find($request->item_id);
				$details->fill($data);
				$return  =  $details->save();
				if($return){
					DB::commit();
					return $this->sendResponse(trans('common.updated_success'),[]);
				}
			}
			else{
				// CREATE
				$return = Language::create($data);
				if($return){
					DB::commit();
					return $this->sendResponse(trans('common.added_success'),[]);
				}
			}
			DB::rollback();
			$this->ajaxError(trans('common.try_again'),[]);

		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	/**
	* CHANGE STATUS
	*/
	public function change_status(Request $request)
	{
		DB::beginTransaction();
		try {
			$query = Language::where('id', $request->id)->update(['status' => $request->status]);
			if ($query) {
				DB::commit();
				return $this->sendResponse(trans('common.updated_success'),['status' => 'success']);
			} else {
				DB::rollback();
				return $this->sendResponse( trans('common.updated_error'),['status' => 'error']);
			}
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
	}

	/**
	*
	* DESTROY
	*
	*/
	public function destroy(Request $request){
        Log::info($request);
        $validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
            Log::info('is there any error');
			$this->ajaxError( trans('common.error'),$validator->errors());
		}

		try{
			// DELETE
			$query = Language::where(['id'=>$request->item_id])->delete();
			if($query){
                Log::info('deleted the lanuguages successfully');
				return $this->sendResponse(trans('common.delete_success'),[]);
			}
			return $this->sendResponse(trans('common.delete_error'),[]);
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}
}
