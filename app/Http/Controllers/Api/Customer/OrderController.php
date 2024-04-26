<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use DB,Settings;
use Authy\AuthyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;

class OrderController extends BaseController
{

	/**
	* CARTS
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request){
      
    $page   = $request->page ?? 1;
    $count  = $request->count ?? '10000';

    if ($page <= 0){ $page = 1; }
    $offset = $count * ($page - 1);

    $user_id = Auth::user()->id;
    if(empty($user_id)){
      return $this->sendError('',trans('customer_api.invalid_user'));
    }

    try{
        $query = Cart::query();
        $query = $query->where(['user_id'=>$user_id])->orderBy('id', 'DESC')->offset($offset)->limit($count)->get();
        
        if($query){
          $details = (object) array('items' => $query);
          $details->total_item = Cart::where(['user_id'=>$user_id])->get()->sum("quantity");
          $details->tax = '0.00';
          $details->total_amount = Cart::where(['user_id'=>$user_id])->get()->sum("total");

          return $this->sendArrayResponse(new CartResource($details), trans('customer_api.data_found_success'));
        }
        return $this->sendArrayResponse('', trans('customer_api.data_found_empty'));
    }catch (\Exception $e) { 
      DB::rollback();
      return $this->sendError('', $e->getMessage()); 
    }
	}

	/**
	*
	* Purchase
	* @return \Illuminate\Http\Response
	*
	*/
	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'plan_id' 		=> 'required|exists:subscription_plans,id',
			'package_id' 	=> 'required|exists:subscription_packages,id',
		]);
		if($validator->fails()){
			return $this->sendValidationError('', $validator->errors()->first());
		}

		$user = Auth::user();
		if(empty($user)){
			$this->sendError([], trans('common.invalid_user'));
		}
		
		DB::beginTransaction();
		try{
			// GET PACKAGE DETAILS
			$package = SubscriptionPackage::where(['status'=>'active', 'id'=>$request->package_id])->first();
			if(empty($package->count())){
				$this->sendError([], trans('common.invalid_package'));
			}
			
			// CREATE ORDER
			$data['custom_order_id'] 	= time();
			$data['order_date']    		= date('Y-m-d');
			$data['user_id']       		= $user->id;
			$data['item_count']    		= $package->count();
			$data['quantity']      		= $package->count();
			$data['total']         		= $package->price;
			$data['grand_total']   		= $package->price;
			 
			$insert = Order::create($data);
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
						return $this->sendError('', trans('customer_api.order_place_error'));
					}else{
						if(isset($payment_order_return['id'])){
							
							$insert->tracking_id = $payment_order_return['id'];
							$insert->update();
							
							DB::commit();
							$response['url'] 			= url('/payment-order/'.$payment_order_return['id']);
							return $this->sendResponse($response, trans('order.confirm_success'));
						}else{
							return $this->sendError('', trans('customer_api.order_place_error'));
						}
					}
				}
			}
			$this->sendError([], trans('order.failed_to_create'));
		} catch (Exception $e) {
			DB::rollback();
			return $this->sendError([], $e->getMessage());
		}
	}
}
