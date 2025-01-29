<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use DB,Settings;
use Authy\AuthyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Api\BaseController;
use App\Models\Helpers\CommonHelper;
use App\Models\Option;
use App\Http\Resources\OptionListResource;

class OptionController extends BaseController
{

	/**
	* Options List
	* @return \Illuminate\Http\Response
	*/
	public function option_list(Request $request)
	{
	    
		$validator = Validator::make($request->all(), [
		  'type' => 'nullable'
		]);
		
		if($validator->fails()){
		  return $this->sendValidationError('', $validator->errors()->first());
		}

		try{
		    if(!$request?->type){
		        $data = Option::all()->groupBy('type')->map(function ($group) {
                    return OptionListResource::collection($group);
                })->toArray();
                return $this->sendArrayResponse($data, trans('customer_api.data_found_success'));
		    }
		    
			// Get Data
			$query = Option::query();
            
			if($request->parent_id){
                $query->where(['parent' => $request->parent_id]);
			}

			$data = OptionListResource::collection($query->where(['type'=>$request->type])->get());
            
			if(count($data)>0){
				return $this->sendArrayResponse($data, trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));

		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	public function option_create(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'slug'		=> 'required|min:3|max:99',
			'title'		=> 'required|min:3|max:99',
			'status'	=> 'required|min:3|max:99',
			'type' => 'required|min:3|max:99'
		]);

        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
			$data = array(
				'slug'		=> $request->slug,
				'title'		=> $request->title,
				'status'	=> $request->status,
				'type'		=> $request->type,
			);

			if($request->parent){
				$data['parent'] = $request->parent;
			}

			// CREATE
			$return = Option::create($data);

			if($return){
				DB::commit();
				return $this->sendResponse([$return], trans('customer_api.data_added_success'));
			}
			DB::rollback();
			$this->sendError([], trans('customer_api.something_went_wrong'));

        }catch (Exception $e) {
            DB::rollback();
            $this->sendError([], $e->getMessage());
        }

    }

	public function option_get(Request $request)
	{
		$validator = Validator::make($request->all(), [
		  'item_id' => 'required'
		]);
		if($validator->fails()){
		  return $this->sendValidationError('', $validator->errors()->first());
		}

		try{
			// Get Data
			$details  =  Option::find($request->item_id);

			if($details){
				return $this->sendArrayResponse($details, trans('customer_api.data_found_success'));
			}
			DB::rollback();
			$this->sendError([], trans('customer_api.something_went_wrong'));

		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	public function option_update(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'slug'		=> 'required|min:3|max:99',
			'title'		=> 'required|min:3|max:99',
			'status'	=> 'required|min:3|max:99',
			'item_id' 	=> 'required',
		]);

        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
			$data = array(
				'slug'		=> $request->slug,
				'title'		=> $request->title,
				'status'	=> $request->status,
				'item_id' 	=> $request->item_id,
			);

			if($request->parent){
				$data['parent'] = $request->parent;
			}

			// UPDATE
			$details  =  Option::find($request->item_id);
			$details->fill($data);
			$return  =  $details->save();

			if($return){

				DB::commit();
				 return $this->sendResponse([], trans('customer_api.update_success'));
			}
			DB::rollback();
			$this->sendError([], trans('customer_api.something_went_wrong'));

        }catch (Exception $e) {
            DB::rollback();
            $this->sendError([], $e->getMessage());
        }

    }

}
