<?php

namespace App\Http\Controllers\Vendors;

 use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Models\Helpers\CommonHelper;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use App\Models\Country;
use Carbon\Carbon;
use App\Models\Option;
use Illuminate\Validation\ValidationException;

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
		//$this->middleware(['auth','vendor_approved','vendor_subscribed']);
		//$this->middleware('permission:vendor_restaurant-edit', ['only' => ['edit','update']]);
	}
  
	// OPTIONS SHOW
	public function show(){
		$user = Auth()->user();
 		if(empty($user)){
			return redirect()->route('vendorDashboard');
		}
		
		$data = Option::where('user_id',$user->id)->first();
		if($data){
			return view('vendors.options.show', compact('data'));
		}
		return redirect()->route('vendorDashboard');
	}
	
	// UPDATE
	public function update(Request $request){
		$validator = Validator::make($request->all(), [
			'title'					=> 'required|min:3|max:99',
			'margin_percentage'		=> 'required|min:1|max:2',
		]);
		if($validator->fails()){
			$this->ajaxValidationError($validator->errors(), trans('common.error'));
		}
		
		$user = Auth()->user();
 		if(empty($user)){
			$this->ajaxError([], trans('common.unauthorized_access'));
		}
		
		try{
			$data = [
				'title'				=> $request->title,
				'margin_percentage'	=> $request->margin_percentage,
			];
			
			$query = Option::where('user_id',$user->id)->update($data);
			if($query){
				$this->sendResponse([], trans('common.update_success'));
			}
			
			$this->sendResponse([], trans('common.try_again'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
}