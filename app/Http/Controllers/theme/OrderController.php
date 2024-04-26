<?php

namespace App\Http\Controllers\theme;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;

class OrderController extends CommonController
{   
	use CommonHelper;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		//$this->middleware(['auth']);
	}
	
	/**
	* 
	* Create a new Order
	* @return void
	*
	*/
	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'plan_id' 		=> 'required|exists:subscription_plans,id',
			'package_id' 	=> 'required|exists:subscription_packages,id',
		]);
		if($validator->fails()){
			$this->ajaxError([], $validator->errors()->first());
		}

		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		DB::beginTransaction();
		try{
			// GET PACKAGE DETAILS
			$package = SubscriptionPackage::where(['status'=>'active', 'id'=>$request->package_id])->first();
			if(empty($package->count())){
				$this->ajaxError([], trans('common.invalid_package'));
			}

			// CREATE ORDER
			$data['custom_order_id'] 	= time();
			$data['order_date']    		= date('Y-m-d');
			$data['user_id']       		= $user->id;
			$data['item_count']    		= $package->count();
			$data['quantity']      		= $package->count();
			$data['total']         		= $package->price;
			$data['grand_total']   		= $package->price;
			
			$insert		 = Order::create($data);
			if($insert){
				// INSERT ORDER ITEMS
				$subscriptionArray = [
				  'user_id'				=> $user->id,
				  'order_id'			=> $insert->id,
				  'plan_id'				=> $package->plan_id,
				  'package_id'			=> $package->id,
				  'expiry_date'			=> date('Y-m-d'),
				  'status'				=> 'inactive',
				];
				$query = CommonHelper::saveSubscription($user, $subscriptionArray);
				if($query){
					$postfields = ['amount'=>number_format((float)$package->price, 0, '.', ''), 'currency'=>'INR', 'receipt'=>'#'.$insert->custom_order_id];
					$payment_order_return = CommonHelper::gateway_create_order($postfields);
					if(empty($payment_order_return)){
						return $this->ajaxError('', trans('customer_api.order_place_error'));
					}else{
						if(isset($payment_order_return['id'])){
							
							$insert->tracking_id = $payment_order_return['id'];
							$insert->update();
							DB::commit();
							
							$response['key'] 			= 'rzp_test_7EpAOUQqF7fvt3';
							$response['amount'] 		= number_format((float)$package->price, 0, '.', '');
							$response['currency'] 		= 'INR';
							$response['name'] 			= 'Bright Matrimony';
							$response['description']	= 'Plan Payment';
							$response['image']			= 'http://brightmatrimonial.com/public/themeAssets/images/logo.svg';
							$response['order_id']		= $payment_order_return['id'];
							$response['account_id']		= 'HjqG4R3N7FND3c';
							$this->sendResponse($response, trans('order.confirm_success'));
						}else{
							return $this->ajaxError('', trans('customer_api.order_place_error'));
						}
					}
				}

				
			}
			
			$this->ajaxError([], trans('order.failed_to_create'));
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError([], $e->getMessage());
		}
	}
	
	/**
	* 
	* Payment the Order
	* @return void
	*
	*/
	public function payment($tracking_id = ''){
		
		if($tracking_id = ''){
			return redirect()->route('order_failedPage');
		}
		
		
		$page		= 'paymentOrder';
        $page_title = trans('title.payment_order');
		
		return view('theme.order.payment',compact('page', 'page_title'));
    }
	
	/**
	* 
	* Confirm the Order
	* @return void
	*
	*/
	public function confirm(Request $request){
		
		
		return redirect()->route('order_successPage');
    }
	
	public function orderSuccess(){
		$page		= 'orderSuccess';
        $page_title = trans('title.order_success');
		
		return view('theme.order.success-message',compact('page', 'page_title'));
    }
	
	public function orderFailed(){
		$page		= 'orderFailed';
        $page_title = trans('title.order_failed');
		
		return view('theme.order.failed-message',compact('page', 'page_title'));
    }
}