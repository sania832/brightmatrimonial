<?php

namespace App\Http\Controllers\theme;

use Auth;
use App;
use App\Http\Controllers\CommonController;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\City;
use Exception;

class CheckoutController extends CommonController
{
	/**
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application first page.
	 */
	public function index()
	{

		$user = Auth()->user();
		if (empty($user)) {
			return redirect()->route('home');
		}

		try {
			$page       	= 'checkoutPage';
			$page_title 	= trans('title.checkout');

			//GET ADDRESS LIST
			$address 		= Address::where('user_id', $user->id)->get();

			// GET ORDER DATA
			$order 			= Order::where(['user_id' => $user->id, 'status' => 'Temporary'])->orderBy('id', 'DESC')->first();
			
			// GET CITY DATA
			$citylist		= City::where(['status' => 'active'])->orderBy('id', 'DESC')->get();

			if (!empty($order)) {
				$order->items = OrderItem::where(['order_id' => $order->id])->get();

				return view('theme.order.checkout', compact('page', 'page_title', 'order', 'address', 'citylist'));
			}

			return redirect()->route('menuPage');
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}
	public function store(Request $request )
	{
		// $validator = Validator::make($request->all(), [
		// 	'phone_no'					=> 'required|numeric',
		// ]);
		// if($validator->fails()){
		// 	$this->ajaxValidationError($validator->errors(), trans('common.error'));
		// }
		try {
			$user = Auth()->user();
			if (empty($user)) {
				$this->ajaxError([], trans('common.unauthorized_access'));
			}

			$data = new Address;
			$data = [
				'user_id'			=> $user->id,
				'phone_no'			=> $request->phone_no,
				'address'			=> $request->address,
				'postal_code'		=> $request->postal_code,
				'address_type'		=> $request->address_type,
				'country_id'		=> $request->country_id,
				'city_id'			=> $request->city_id,
			];

			// $data = new Address;
			// $data->phone_no = $request->phone_no;
			// $data->address = $request->address;
			// $data->postal_code = $request->postal_code;
			// $data->address_type = $request->address_type;
			// $return = $data->save();
			$id = $request->id;
			if (empty($request->id)) {
				$return = Address::create($data);
				if ($return) {
					$this->sendResponse([], trans('product.added_success'));
				}
			} else {
				$return = Address::where('id', $id)->update($data);
				if ($return) {
					$this->sendResponse([], trans('product.updated_success'));
				}
			}
			$this->sendResponse([], trans('common.try_again'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
	// DESTROY
	public function destroy(Request $request)
	{
		// $validator = Validator::make($request->all(), [
		// 	'item_id' => 'required',
		// ]);
		// if($validator->fails()){
		// 	$this->ajaxError($validator->errors(), trans('common.error'));
		// }

		try {
			// DELETE
			$query = Address::where(['id' => $request->id])->delete();
			if ($query) {
				$this->sendResponse([], trans('common.delete_success'));
			}
			$this->sendResponse([], trans('common.delete_error'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}

	public function getAddressById(Request $request)
	{
		try {
			$data = Address::where(['id' => $request->id])->get();
			return response()->json($data);
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
}
