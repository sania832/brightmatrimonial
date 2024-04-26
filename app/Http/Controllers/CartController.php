<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Helpers\CommonHelper;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Option;

class CartController extends CommonController
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
		// $this->middleware('permission:vendor-product-edit', ['only' => ['edit','update']]);
	}
	
	// ADDD TO CART
	public function ajax_add(Request $request){
		
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
			$this->ajaxError([], trans('common.error'));
		}
		
		$quantity 	= $request->quantity ?? 1;
		$user 		= Auth()->user();
		
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}else if(empty(session()->get('shop_id'))){
			$this->ajaxError([], trans('cart.invalid_shop'));
		}else if($quantity < 1){
			$this->ajaxError([], 'Invalid quantity');
		}else if($quantity > 100){
			$this->ajaxError([], 'Maximum quantity limit is 100');
		}
		
		DB::beginTransaction();
		try{
			$data = Product::where('id', $request->item_id)->first();
			
			if($data){
				$margin_percentage 	= '0';
				$shop_options 		= Option::where(['user_id'=>session()->get('shop_id')])->first();
				if($shop_options){
					$margin_percentage = $shop_options->margin_percentage;
				}
				$price 				= round($data->price + ($data->price / 100) * $margin_percentage);
				$total 				= round($data->price + ($data->price / 100) * $margin_percentage) * $quantity;
				
				$item_exist 		= Cart::where('user_id', $user->id)->where('product_id',$data->id)->first();

				// INSERT INTO CART
				$insertData = [
					'user_id'    	=> $user->id,
					'product_id'    => $data->id,
					'customer_id'   => $user->id,
					'title'   		=> $data->title,
					'quantity'      => $quantity,
					'price'         => $price,
					'total'         => $total,
					'date'          => date('Y-m-d'),
				];

				//Update quantity if item already exist in the cart
				if($item_exist){
					$item_exist->quantity 	= $quantity;
					$item_exist->price 		= $price;
					$item_exist->total 		= $total;
					$item_exist->save();
				}
				else {
					Cart::create($insertData);
				}
				
				$cartData = Cart::where('user_id', $user->id)->get();
				if($cartData){
					DB::commit();
					$this->sendResponse($cartData, trans('cart.add_success'));
				}
			}
			DB::rollback();
			$this->ajaxError([], trans('cart.add_failed'));
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError([], $e->getMessage());
		}
	}
	
	// LIST
	public function ajax_list(Request $request){
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		try{
			$cartData = Cart::with(['product'])->where('user_id', $user->id)->get();
			if($cartData){
				DB::commit();
				$return['list'] = $cartData;
				$return['sub_total'] = number_format($cartData->sum('total'), 2, '.', '');
				$return['delivery_fee'] = '0.00';
				$return['tax'] = '0.00';
				$return['total'] = number_format($cartData->sum('total'), 2, '.', '');
				$this->sendResponse($return, trans('cart.data_found_success'));
			}
			
			$this->sendResponse([], trans('cart.data_found_empty'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
	
	// Delete Cart
	public function deleteCart(Request $request){
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		try{
			$cartData = Cart::where(['id'=>$request->item_id, 'user_id'=>$user->id])->delete();
			if($cartData){
				$this->sendResponse([], trans('cart.delete_success'));
			}
			
			$this->sendResponse([], trans('cart.delete_failed'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
}