<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use DB,Settings;
use Authy\AuthyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use App\Models\Helpers\CommonHelper;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPackage;
use App\Models\Subscription;

use App\Http\Resources\SubscriptionPlanListResource;
use App\Http\Resources\SubscriptionPackageListResource;

class SubscriptionController extends BaseController
{

	/**
	* Options List
	* @return \Illuminate\Http\Response
	*/
	public function plans(Request $request)
	{
		try{

		  // Get Data
		  $result = SubscriptionPlan::where(['status'=>'active'])->orderBy('priority', 'ASC')->get();
		  foreach($result as $key=> $list){
			  $result[$key]->packages = SubscriptionPackageListResource::collection(SubscriptionPackage::where(['plan_id'=>$list->id,'status'=>'active'])->get());
		  }
		  $data = SubscriptionPlanListResource::collection($result);
		  if(count($data)>0){
			return $this->sendArrayResponse($data, trans('customer_api.data_found_success'));
		  }
		  return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
		  
		}catch (\Exception $e) { 
			return $this->sendError('', $e->getMessage());
		}
	}
}