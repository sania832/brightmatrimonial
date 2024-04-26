<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\Department;
use App\Models\country;
use App\Models\StoreCategory;
use Validator,Auth,DB;
use Illuminate\Validation\ValidationException;
use App\Models\Helpers\CommonHelper;

class CategoryController extends CommonController
{
  
    use CommonHelper;

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:category-list', ['only' => ['index','show']]);
        //$this->middleware('permission:category-create', ['only' => ['create','store']]);
        //$this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        //$this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
	
	// INDEX
	public function index(){
		try{
			return view('vendors.categories.index');
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
	
	// VENDOR CATEGORY LIST
	public function ajax(Request $request){
		
		$page     = $request->page ?? '1';
		$count    = $request->count ?? '100';
		
		if ($page <= 0){ $page = 1; }
		$start  = $count * ($page - 1);
		
		$user = Auth()->user();
 		if(empty($user)){
			return redirect()->route('vendorDashboard');
		}
		try{
			$query = new MenuCategory();
			
			$data = $query->orderBy('id', 'DESC')->offset($start)->limit($count)->get();
			if(count($data) > 0){
				foreach($data as $key=> $list){
					$selected 	= '';
					$details 	= StoreCategory::where(['category_id'=>$list->id, 'user_id'=>$user->id])->first();
					if($details){ $selected = 'selected'; }
					$data[$key]->status = '<select class="form-control status" name="status" id="'.$list->id.'">
								<option value="Deactive">Deactive</option>
								<option value="Active" '. $selected .'>Active</option>
						</select>';
				}
				$this->sendResponse($data, trans('common.data_found'));
			}
			$this->sendResponse([], trans('common.empty_data'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
	
	// SAVE
	public function save(Request $request){
		
		if(empty($request->category_id)){
			$this->ajaxError([], 'Invalid category');
			
		}else if(empty($request->status)){
			$this->ajaxError([], 'Invalid Status');
		}
		
		$user = Auth()->user();
 		if(empty($user)){
			$this->ajaxError([], trans('common.unauthorized_access'));
		}
		
		try{
			$data = [
				'category_id'		=> $request->category_id,
				'user_id'			=> $user->id,
			];
			
			$details = StoreCategory::where(['category_id'=>$request->category_id, 'user_id'=>$user->id])->first();
			if($details){
				// DELETE
				$query = StoreCategory::where(['category_id'=>$request->category_id, 'user_id'=>$user->id])->delete();
				if($query){
					$this->sendResponse([], trans('Deactived Successfully'));
				}
			}else{
				// CREATE
				$return = StoreCategory::create($data);
				if($return){
					$this->sendResponse([], trans('Actived Successfully!!'));
				}
			}
			
			$this->ajaxError([], trans('common.try_again'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
}