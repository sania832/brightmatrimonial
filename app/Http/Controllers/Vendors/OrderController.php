<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Helpers\CommonHelper;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\HospitalDepartment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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
        $this->middleware('auth');
        $this->middleware('permission:res_order-list', ['only' => ['index','show']]);
        $this->middleware('permission:res_order-create', ['only' => ['create','store']]);
        $this->middleware('permission:res_order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:res_order-delete', ['only' => ['destroy']]);
    }
  
	// List Page
	public function index(){
		return view('vendors.order.list');
	}
  
	// List 
	public function ajax($id = null){
		try{
			// GET LIST
			$query = Order::where('status','!=','Temporary')->orderBy('id', 'DESC')->get();
			if(count($query) > 0){
				foreach($query as $key=> $list){
					$query[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("orders.show",$list->id) .'"><i class="fa fa-eye"></i></a>
											</div>';

					$query[$key]->customer_name = $list->user->name;
					if($list->payment_method_id == '1'){
						$query[$key]->payment_mode = 'COD';
					} else {
						$query[$key]->payment_mode = 'Online';
					}
					
					if($list->payment_status == null){
						$query[$key]->payment_status = 'Pending';
					}

					//order status
					$order_status = '<option value="New">New</option>';
					
					if ($list->status == 'Received') {
						$order_status = '<option value="Received" selected>New</option>';
						$order_status .= '<option value="Accepted">Accept</option>';
						$order_status .= '<option value="Rejected">Reject</option>';
						
					} elseif ($list->status == 'Accepted') {
						$order_status = '<option value="Accepted" selected>Accepted</option>';
						$order_status .= '<option value="Preparing">Preparing</option>';
						
					} elseif ($list->status == 'Preparing') {
						$order_status = '<option value="Preparing" selected>Preparing</option>';
						$order_status .= '<option value="Dispatched">Dispatched</option>';
						
					} elseif ($list->status == 'Dispatched') {
						$order_status = '<option value="Dispatched" selected>Dispatched</option>';
						$order_status .= '<option value="Delivered">Delivered</option>';
						
					} elseif ($list->status == 'Delivered') {
						$order_status = '<option value="Delivered" selected>Delivered</option>';
						
					} elseif ($list->status == 'Canceled') {
						$order_status = '<option value="Canceled" selected>Canceled</option>';
					}
					
					$query[$key]->status = '<select class="form-control status" name="status" id="'.$list->id.'">'. $order_status .'</select>';

				}
				$this->sendResponse($query, trans('order.data_found_success'));
			}
			$this->sendResponse([], trans('order.data_found_empty'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}

	/**
	*
	* Change Order Status.
	*
	**/
	public function status(Request $request){
	    $validator = Validator::make($request->all(), [
			'id'				=> 'required',
			'status'			=> 'required|min:3|max:99',
		]);
		if($validator->fails()){
			$this->ajaxValidationError($validator->errors(), trans('common.error'));
		}
		
		$user = Auth()->user();
 		if(empty($user)){
			$this->ajaxError([], trans('common.unauthorized_access'));
		}
		
		DB::beginTransaction();
	    try {
			
	        $order = Order::where('id',$request->id)->update(['status'=>$request->status]);
	        if($order)
	        {
	          DB::commit();
	          $this->sendResponse(['status'=>'success'], trans('order.status_updated_successfully'));

	        } else {
	          DB::rollback();
	          $this->sendResponse(['status'=>'error'], trans('order.status_not_updated'));
	        }
	        
	    } catch (Exception $e) {
	        DB::rollback();
	        $this->ajaxError([], $e->getMessage());
	    }
	}

	// SHOW
	public function show($id = null){
		$order = Order::find($id);
		return view('vendors.order.show',compact('order'));
	}
  
}