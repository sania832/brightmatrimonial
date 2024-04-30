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
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class OptionController extends CommonController
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
	public function index($type = ''){
		try{
			// dd($type);
			if (empty($type)) {
				return redirect()->route('home')->with('error', trans('common.data_found_success'));
			}

			return view('admin.options.list', compact('type'));
		} catch (Exception $e) {
			return redirect()->route('home')->with('error', $e->getMessage());
		}
	}

	// CREATE
	public function create($type = ''){
		try{
			$parent = [];
			if(empty($type)) {
				return redirect()->route('home')->with('error', trans('common.data_found_success'));
			}
			if($type == 'sub_cast') {
				$parent = Option::where('type', 'cast')->orderBy('id','DESC')->get();

			}else if($type == 'sub_gotra') {
				$parent = Option::where('type', 'gotra')->orderBy('id','DESC')->get();

			}else if($type == 'cast') {
				$parent = Option::where('type', 'religion')->orderBy('id','DESC')->get();
			}
			return view('admin.options.add', compact('type','parent'));
		} catch (Exception $e) {
			return redirect()->route('home')->with('error', $e->getMessage());
		}
	}

	// EDIT
	public function edit($id = null){
		$data = Option::find($id);

        // dd($data);

		$parent = [];
		if($data->type == 'cast'){
			$parent = Option::where('type', 'community')->orderBy('id','DESC')->get();

		}else if($data->type == 'sub_cast'){
			$parent = Option::where('type', 'cast')->orderBy('id','DESC')->get();

		}else if($data->type == 'sub_gotra'){
			$parent = Option::where('type', 'gotra')->orderBy('id','DESC')->get();
		}

		return view('admin.options.edit',compact('data','parent'));
	}

	public function ajax(Request $request){
		$page     = $request->page ?? '1';
		$count    = $request->count ?? '10';
		$status    = $request->status ?? 'all';

		if ($page <= 0){ $page = 1; }
		$start  = $count * ($page - 1);

		try{
			// DB::enableQueryLog();

			// $query = DB::table('options as O')
			// ->select('O.*', 'OP.title AS parentName')
			// ->join('options AS OP','O.parent','=','OP.id','left outer')
			// ->where('O.type','=',$request->type)
			// ->get();

			// GET LIST
            $query = Option::where('type', $request->type)->orderBy('id','DESC')->offset($start)->limit($count)->get();

			if($query){
				foreach($query as $key=> $list){
					$query[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("optionEdit",[$list->id]) .'"><i class="fa fa-eye"></i></a>
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
                Log::info($query);
				return $this->sendResponse( trans('common.data_found_success'),$query);
			}

			return $this->sendResponse(trans('common.data_found_empty'),[]);

		} catch (Exception $e) {
			$this->ajaxError( $e->getMessage(),[]);
		}
	}

	// STORE
	public function store(Request $request){
		// dd($request);
		$validator = Validator::make($request->all(), [
			'slug'		=> 'required|min:3|max:150',
			'title'		=> 'required|min:3|max:150',
			'status'	=> 'required|min:3|max:150',
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
				return $this->ajaxValidationError( trans('common.error'),$validator->errors(),);
			}
		}else{
			$validator = Validator::make($request->all(), [
				'type' => 'required|min:3|max:99',
			]);
			if($validator->fails()){
				return $this->ajaxError( trans('common.invalid_option'),'');
			}
		}

		DB::beginTransaction();
		try{
			$data = [
				'slug'		=> $request->slug,
				'title'		=> $request->title,
				'status'	=> $request->status,
			];

			if($request->parent){ $data['parent'] = $request->parent; }

			if($request->item_id){

				// UPDATE
				$details  =  Option::find($request->item_id);
				$details->fill($data);
				$return  =  $details->save();

				if($return){

					DB::commit();
					return $this->sendResponse( trans('common.updated_success'),[]);
				}
			} else{
				// CREATE

				$data['type'] = $request->type;
				$return = Option::create($data);
				if($return){

					DB::commit();
					return $this->sendResponse( trans('common.added_success'),[]);
				}
			}
			DB::rollback();
			$this->ajaxError( trans('common.try_again'),[]);

		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError( $e->getMessage(),[]);
		}
	}

	/**
	*
	* CHANGE STATUS
	*
	*/
	public function change_status(Request $request)
	{
        DB::beginTransaction();
		try {
			$query = Option::where('id', $request->id)->update(['status' => $request->status]);

			if ($query) {
				DB::commit();
				return $this->sendResponse(trans('common.updated_success'),['status' => 'success']);
			} else {
				DB::rollback();
				return $this->sendResponse(trans('common.updated_error'),['status' => 'error']);
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
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
			return $this->ajaxError( trans('common.error'),$validator->errors());
		}

		try{
			// DELETE
			$query = Option::where(['id'=>$request->item_id])->delete();
			if($query){
				return $this->sendResponse( trans('common.delete_success'),[]);
			}
			return $this->sendResponse( trans('common.delete_error'),[]);
		} catch (Exception $e) {
			$this->ajaxError( $e->getMessage(),[]);
		}
	}
}
