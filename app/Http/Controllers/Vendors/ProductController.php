<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Helpers\CommonHelper;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;
use App\Models\MenuCategory;
use App\Models\AddonGroup;
use App\Models\Product;
use App\Models\MenuAddon;
use App\Models\MenuVariation;
use App\Models\Variation;
use App\Models\ImageAttechment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ProductController extends CommonController
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
        $this->middleware('permission:res_menu-list', ['only' => ['index','show']]);
        $this->middleware('permission:res_menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:res_menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:res_menu-delete', ['only' => ['destroy']]);
    }
  
	// ADD NEW
	public function index(){
		return view('vendors.product.list');
	}

	// CREATE
	public function create(){
		
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		DB::beginTransaction();
		try {
			$data = [
				'title:en'         	=> '',
				'description:en'   	=> '',
				'price'            	=> '',
				'menu_category_id' 	=> '',
				'owner_id'			=> $user->id,
			];
			
			// CREATE
			$return = Product::create($data);
			if($return){
				DB::commit();
				//route("products.edit",$return->id);
				return redirect(url('vendors/products/'. $return->id .'/edit'));
			}
			return redirect(url('vendors/products'));
		} catch (Exception $e) {
	        DB::rollback();
	        return redirect(url('vendors/products'));
	    }
	}
  
	// EDIT
	public function ajax(Request $request){
		$page     = $request->page ?? '1';
		$count    = $request->count ?? '10';
		$status    = $request->status ?? 'all';
		
		if ($page <= 0){ $page = 1; }
		$start  = $count * ($page - 1);
	  
		try{
			// GET LIST
			$user = Auth()->user();
			$query = Product::where(['owner_id' => $user->id]);
			
			// STATUS
			if($status != 'all'){
				$query->where('status', $status);
			}
			
			$data  = $query->orderBy('id', 'DESC')->offset($start)->limit($count)->get();
			if($data){
				foreach($data as $key=> $list){
					$data[$key]->action = '<div class="widget-content-right widget-content-actions">
											<a class="border-0 btn-transition btn btn-outline-success" href="'. route("products.edit",$list->id) .'"><i class="fa fa-eye"></i></a>
											<button class="border-0 btn-transition btn btn-outline-danger" onclick="deleteThis('. $list->id .')"><i class="fa fa-trash-alt"></i></button>
											</div>';
					if($list->image){ $data[$key]->image  = asset('public/'.$list->image); }else { $data[$key]->image  = ''; }
				}
				$this->sendResponse($data, trans('product.data_found_success'));
			}
			$this->sendResponse([], trans('product.data_found_empty'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
  
	// EDIT
	public function edit($id = null){
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		$categories		=  MenuCategory::where('owner_id', $user->id)->get();
		$addonGrps 		= AddonGroup::where('status','active')->get();
		$variations 	= Variation::where('status','active')->get();
		$attachments 	= ImageAttechment::where('product_id',$id)->get();
		$product = Product::find($id);
		
		return view('vendors.product.update',compact('product', 'categories', 'attachments', 'addonGrps', 'variations'));
	}
  
	// STORE
	public function store(Request $request){
		$validator = Validator::make($request->all(), [
			'title_in_english'       => 'required|min:3|max:99',
			'description_in_english' => 'required|min:3|max:10000',
			'price'                  => 'required|min:1|numeric',
			'menu_category_id'       => 'required',
			'weight'       		 	 => 'required',
			//'image'                => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		]);
		if($validator->fails()){
			$this->ajaxValidationError($validator->errors(), trans('common.error'));
		}
		$data =  $request->all();
		$user = Auth()->user();
		
 		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		
		if($request->item_id){
			$validator = Validator::make($request->all(), [
				'item_id' => 'required',
			]);
			if($validator->fails()){
				$this->ajaxValidationError($validator->errors(), trans('common.error'));
			}
		}
		
		try{
			$data = [
				'title:en'         	=> $request->title_in_english,
				'description:en'   	=> $request->description_in_english,
				'price'            	=> $request->price,
				'menu_category_id' 	=> $request->menu_category_id,
				'weight' 		   	=> $request->weight,
				'video_url'			=> $request->video_url,
				//'delivery_type'	=> $request->delivery_type,
				//'is_taxable'		=> $request->is_taxable,
				//'choice'			=> $request->choice,
			];
			
			
			// MEDIA UPLOAD
			if(!empty($request->image)){
				$data['image'] =  $this->saveMedia($request->file('image'));
			}

			if($request->item_id){
				// UPDATE
				$product  =  Product::find($request->item_id);
				if($request->image == 'undefined'){
					$data['image'] = $product->image;
				}
				$product->fill($data);
				$return  =  $product->save();
				
				if($return){
					$this->sendResponse([], trans('product.updated_success'));
				}
			} else{
				$data['owner_id'] = $user->id;
				
				// CREATE
				$return = Product::create($data);
				if($return){
					$this->sendResponse([], trans('product.added_success'));
				}
			}
			
			$this->ajaxError([], trans('common.try_again'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
  }
  
	public function store_images(Request $request){
		
		$validator = Validator::make($request->all(), [
			'item_id'	=> 'required|min:1|max:99',
		]);
		if($validator->fails()){
			$this->ajaxValidationError($validator->errors(), trans('common.error'));
		}
		
		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError([], trans('common.invalid_user'));
		}
		if($request->item_id){
			$validator = Validator::make($request->all(), [
				'item_id' => 'required',
			]);
			if($validator->fails()){
				$this->ajaxValidationError($validator->errors(), trans('common.error'));
			}
		}
	
		try{
			$data = [
				'product_id'	=> $request->item_id,
				'alt'			=> '',
			];
			
			// MEDIA UPLOAD
			if(!empty($request->image)){
				$data['image'] =  $this->saveMedia($request->file('image'));
				
				// CREATE
				$return = ImageAttechment::create($data);
				if($return){
					$this->sendResponse([], trans('product.added_success'));
				}
			}
			$this->ajaxError([], trans('common.try_again'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}

	// DESTROY
	public function destroy(Request $request){
		$validator = Validator::make($request->all(), [
			'item_id' => 'required',
		]);
		if($validator->fails()){
			$this->ajaxError($validator->errors(), trans('common.error'));
		}
		
		try{
			// DELETE
			$query = Product::where(['id'=>$request->item_id])->delete();
			if($query){
				$this->sendResponse([], trans('common.delete_success'));
			}
			$this->sendResponse([], trans('common.delete_error'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
	public function destroyImage(Request $request){
		$validator = Validator::make($request->all(), [
			'id' => 'required',
		]);
		if($validator->fails()){
			$this->ajaxError($validator->errors(), trans('common.error'));
		}
		
		try{
			// DELETE
			$query = ImageAttechment::where(['id'=>$request->id])->delete();
			if($query){
				$this->sendResponse([], trans('common.delete_success'));
			}
			$this->sendResponse([], trans('common.delete_error'));
		} catch (Exception $e) {
			$this->ajaxError([], $e->getMessage());
		}
	}
}