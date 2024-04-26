<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB,Settings;
use Authy\AuthyApi;
use App\Models\Language;
use App\Http\Resources\LanguageListResource;

class LanguageController extends BaseController
{
    /**
     * Language List
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        $search = $request->search;
		$page   = $request->page ?? '0';
		$count  = $request->count ?? '10000';
		
		if ($page <= 0){ $page = 1; }
		$start  = $count * ($page - 1);

        try{
            $query = Language::query();
            /* SEARCH */
            if($search){
                $query->where('title','like','%'.$search.'%');
            }
            $query = $query->orderBy('id')->offset($start)->limit($count)->get();
            return $this->sendArrayResponse(LanguageListResource::collection($query), trans('customer_api.data_found_success'));
        }catch (\Exception $e) { 
          return $this->sendError('', $e->getMessage());
        }
    }
}
