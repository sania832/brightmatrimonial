<?php

namespace App\Http\Controllers\theme;

use Auth,App;
use Exception;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPackage;

class PlanController extends CommonController
{
	/**
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	* Show the application first page.
	*/
	public function index()
	{
		try {
			$page       	= 'planPage';
			$page_title 	= trans('title.plan');

			//GET PLAN LIST
			$plans 		= SubscriptionPlan::where('status', 'active')->get();
			if(!empty($plans)){
				foreach($plans as $key=> $plan){
					$plans[$key]->packages =  SubscriptionPackage::where(['status'=>'active', 'plan_id'=>$plan->id])->get();
				}
			}

			return view('theme.plan.index', compact('page','page_title','plans'));
		} catch (Exception $e) {
			//return redirect()->back()->withError($e->getMessage());
		}
	}
}