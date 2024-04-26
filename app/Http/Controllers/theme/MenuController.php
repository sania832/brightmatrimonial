<?php

namespace App\Http\Controllers\theme;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Auth;
use App;

use App\Models\Product;
use App\Models\MenuCategory;
use App\Models\ImageAttechment;
use App\Models\Option;

class MenuController extends CommonController
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
	public function index(){
		
		if(isset($_GET['shop_id'])){
			session()->put('shop_id', $_GET['shop_id']);
		}
		if(empty(session()->get('shop_id'))){
			header("Location: ". url('404')); exit;
		}
		
		try {
			$page       		= 'menu';
			$page_title 		= trans('title.category_index');
			$shop_id 			= session()->get('shop_id');
			$margin_percentage 	= '0';
			
			$shop_options 		= Option::where(['user_id'=>$shop_id])->first();
			if($shop_options){
				$margin_percentage = $shop_options->margin_percentage;
			}
		  
			$menu = MenuCategory::select('menu_category.*')
			  ->join('products as t1', 't1.menu_category_id', '=', 'menu_category.id')
			  ->join('store_categories as t2', 't2.category_id', '=', 'menu_category.id')
			  ->where('t1.status', 'active')
			  ->where('t2.user_id', $shop_id)
			  ->groupBy('menu_category.id')
			  ->get();
			if(!empty($menu)){
				foreach($menu as $key=> $list){
					$products = Product::where(['status'=>'active', 'menu_category_id'=>$list->id])->get();
					if(!empty($products)){
						foreach($products as $pkey=> $plist){
							if($margin_percentage > 0){
								$plist['price'] = number_format(round($plist['price'] + ($plist['price'] / 100) * $margin_percentage), 2);
							}
						}
					}
					$menu[$key]['products'] = $products;
				}
			}
			return view('theme/menuPage', compact('page', 'page_title', 'shop_id', 'menu'));
			
		} catch (Exception $e) {
		  return redirect()->back()->withError($e->getMessage());
		}
	}
	
	/**
	* Product Details page
	*/
	public function show($id = null){
		if(isset($_GET['shop_id'])){
			session()->put('shop_id', $_GET['shop_id']);
		}
		if(empty(session()->get('shop_id'))){
			header("Location: ". url('404')); exit;
		}
		
		try {
			$page		= 'product_details';
			$page_title	= trans('title.product_details');
			$shop_id	= session()->get('shop_id');
			
			$data		= Product::where('id', $id)->first();
			if(!empty($data)){
				$related_products 	= Product::where('status', 'active')->inRandomOrder()->groupBy('id')->offset(0)->limit(10)->get();
				$data->attachments	= ImageAttechment::where('product_id', $id)->get();
				
				return view('theme/product/show', compact('page','page_title','shop_id','data', 'related_products'));
			}
			
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}
}