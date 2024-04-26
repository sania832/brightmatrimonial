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
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Log;

class QuestionController extends CommonController
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
		return view('admin.questions.list');
	}

	// CREATE
	public function create(){

		return view('admin.questions.add');
	}

	public function ajax(Request $request,$id = null){

        Log::info($request);
		try{
			// GET LIST
            $page     = $request->page ?? '1';
            $count    = $request->count ?? '10';

            if ($page <= 1){ $page = 1; }
            $start  = $count * ($page - 1);

            $query = Question::query();

            if(!empty($request->status) && $request->status != 'all'){
				$query->where('status', $request->status);
			}

            if (!empty($request->search)) {
                $query->where('slug', 'like', '%' . $request->search . '%');
            }

			$data  = $query->orderBy('id', 'DESC')->offset($start)->limit($count)->get();

			if($data){
				foreach($data as $key=> $list){
					$data[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("questions.edit",$list->id) .'"><i class="fa fa-eye"></i></a>
											<button class="border-0 btn-transition btn btn-outline-danger" onclick="deleteThis('. $list->id .')"><i class="fa fa-trash-alt"></i></button>
											</div>';

					$status_array = ['active'=>'', 'inactive'=>''];
					if($list->status == 'active') { $status_array['active'] = 'selected'; }
					if($list->status == 'inactive') { $status_array['inactive'] = 'selected'; }
					$status = "<select class='form-control change_status' id='$list->id'>
										<option value='active' 	". $status_array['active'] .">Active</option>
										<option value='inactive'". $status_array['inactive'] .">Inactive</option>
									</select>";

					$data[$key]->status = $status;
				}

				return $this->sendResponse(trans('common.data_found_success'),$data);
			}
			return $this->sendResponse(trans('common.data_found_empty'),[]);

		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}

	}

	// EDIT
	public function edit($id = null){
		$data 	 = Question::find($id);
		$options = QuestionOption::where('question_id', $id)->get();
		return view('admin.questions.edit',compact('data', 'options'));
	}

	// STORE
	public function store(Request $request){
		$validator = Validator::make($request->all(), [
			'slug'						=> 'required|min:3|max:99',
			'man_question'				=> 'required|min:3|max:99',
			'women_question'			=> 'required|min:3|max:99',
			'status'					=> 'required|min:1|max:99',
			'man_option_a'				=> 'required|min:3|max:99',
			'man_option_b'				=> 'required|min:3|max:99',
			'man_option_c'				=> 'required|min:3|max:99',
			'man_option_d'				=> 'required|min:3|max:99',
			'women_option_a'			=> 'required|min:3|max:99',
			'women_option_b'			=> 'required|min:3|max:99',
			'women_option_c'			=> 'required|min:3|max:99',
			'women_option_d'			=> 'required|min:3|max:99',
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
				'slug'		=> $request->slug,
				'Male'		=> $request->man_question,
				'Female'	=> $request->women_question,
				'status'	=> $request->status,
			];

			$options = [
				['type'=>'a', 'Male' => $request->man_option_a, 'Female' => $request->women_option_a],
				['type'=>'b', 'Male' => $request->man_option_b, 'Female' => $request->women_option_b],
				['type'=>'c', 'Male' => $request->man_option_c, 'Female' => $request->women_option_c],
				['type'=>'d', 'Male' => $request->man_option_d, 'Female' => $request->women_option_d],
			];

			if($request->item_id){
				// UPDATE
				$details  =  Question::find($request->item_id);
				$details->fill($data);
				$return  =  $details->save();

				if($return){
					// Update Options
					foreach($options as $key=> $list){
						$data = [
							'type' 			=> $list['type'],
							'Male'			=> $list['Male'],
							'Female'		=> $list['Female'],
						];
						$this->saveOption($data, $request->item_id, $list['type']);
					}
					DB::commit();
					return $this->sendResponse(trans('common.updated_success'),[]);
				}
			}
			else{
				// CREATE
				$return = Question::create($data);
				if($return){

					// Create Options
					foreach($options as $key=> $list){
						$data = [
							'question_id' 	=> $return->id,
							'type' 			=> $list['type'],
							'Male'			=> $list['Male'],
							'Female'		=> $list['Female'],
						];
						$this->saveOption($data);
					}
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

	public function saveOption($data, $update_id = 0, $type = ''){

		if(!empty($update_id)){
			QuestionOption::where(['question_id'=>$update_id, 'type'=>$type])->update($data);
		}else{
			QuestionOption::create($data);
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
			$query = Question::where('id', $request->id)->update(['status' => $request->status]);

			if ($query) {
				DB::commit();
				return $this->sendResponse(trans('common.updated_success'),['status' => 'success'], );
			} else {
				DB::rollback();
				return $this->sendResponse(trans('common.updated_error'),['status' => 'error']);
			}
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError([],$e->getMessage());
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
			$this->ajaxError(trans('common.error'),$validator->errors());
		}

		try{
			// DELETE
			$query = Question::where(['id'=>$request->item_id])->delete();
            $options = QuestionOption::where(['question_id'=>$request->item_id])->delete();
			if($query){
				return $this->sendResponse(trans('common.delete_success'),[]);
			}
			return $this->sendResponse(trans('common.delete_error'),[]);
		} catch (Exception $e) {
			$this->ajaxError($e->getMessage(),[]);
		}
	}
}
