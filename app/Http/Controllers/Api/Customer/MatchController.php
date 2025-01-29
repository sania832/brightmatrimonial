<?php

namespace App\Http\Controllers\Api\Customer;

use Validator;
use DB,Settings;
use Authy\AuthyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use App\Models\Helpers\CommonHelper;
use App\Models\User;
use App\Models\Matches;
use App\Models\QuestionAnswer;

use App\Http\Resources\MatchesListResource;

class MatchController extends BaseController
{

	/**
     * GET USER PROFILE
     *
     * @return \Illuminate\Http\Response
     */
    public function user_profile(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'user_id'	=> 'required|string|min:1|max:99999',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

        DB::beginTransaction();
        try{

            // GET USER DATA
            $user = User::where('id', $request->user_id)->first();
			return $this->sendResponse(new MatchesListResource($user), trans('customer_api.data_found_success'));

        }catch(\Exception $e){
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	/**
	*
	* Matches List
	*
	*/
	public function matches(Request $request)
	{
		$search = $request->search;
		$type 	= $request->type ?? 'daily';
        $page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}
		// $gender = [Male => Female, Female => Male]
		try{
			$gender = [];
			if($user->bio?->relation_type == "2") { // LGBTQ
				$gender = ["Female", "Male"];
			} else if($user->bio?->relation_type == "3") { //Heterosexual
				if($user->gender == "Male"){
					$gender = ["Female"];
				} else {
					$gender = ["Male"];
				}
			} else if($user->bio?->relation_type == "4") { //Asexual
				if($user->gender == "Male"){
					$gender = ["Male"];
				} else {
					$gender = ["Female"];
				}
			} else if($user->bio?->relation_type == "5"){ //Bisexual
					 $gender = ["Female", "Male"];
			} else {
				$gender = ["Male" => "Female", "Female" => "Male"];
			}

			if($type == 'question-match'){
				$query = Matches::select('t2.*')->join('users as t2', 't2.id', '=', 'matches.match_id')
						->whereIn('t2.gender' , $gender )
						->where('user_id', '=', $user->id)
						// ->groupBy('matches.match_id')
						->orderBy('matches.id', 'ASC')
						->offset($offset)
						->limit($count)
						->get();
						$this->refreshMatches();
			}else if($type == 'daily'){
    			$query = User::where(['user_type'=>'Customer'])
    						->where("id", "!=", $user->id)
    						->whereIn('gender', $gender)
    						->offset($offset)->limit(10)
    						->inRandomOrder()
    						->get();
			}else if($type == 'just-joined'){
				$query = User::where(['user_type'=>'Customer'])
							->whereIn('gender', $gender)
							->where("id", "!=", $user->id)
							->where('created_at', '>=', Carbon::now()
							->subDays(15))->offset($offset)
							->limit(10)
							->inRandomOrder()
							->get();
			}else if($type == 'verified'){
				$query = User::where(['user_type'=>'Customer'])
							->whereIn('gender', $gender)
							->where("id", "!=", $user->id)
							->where('is_approved', '=', 1)
							->offset($offset)
							->limit($count)
							->inRandomOrder()
							->get();
			}else{
				return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
			}

			if(count($query)>0){
				return $this->sendArrayResponse(MatchesListResource::collection($query), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));

		}catch (\Exception $e) {
		  //  dd($e);
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	*
	* Search List
	*
	*/
	public function search(Request $request)
	{
		$page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		try{

			// GET LIST
			$query = User::select('users.*');

			/* FILTERS */
            if($request->name){
                $query->where('name','like','%'.$request->name.'%');
            }
			if($request->religion){
				$query->join('users_bio as t2', 't2.user_id', '=', 'users.id');
                $query->where('religion', '=', $request->religion);
            }


			$query = $query->where(['user_type'=>'Customer'])->where('users.id', '!=', $user->id)->orderBy('id', 'DESC')->offset($offset)->limit($count)->get();
			if(count($query)>0){
				return $this->sendArrayResponse(MatchesListResource::collection($query), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));

		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	*
	* Saved List
	*
	*/
	public function saved_profiles(Request $request)
	{
		$search = $request->search;
        $page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		try{
			// GET LIST
			$query = User::where(['user_type'=>'Customer'])->orderBy('id','DESC')->orderBy('id','DESC')->offset($offset)->limit($count)->get();

			if(count($query)>0){
				return $this->sendArrayResponse(MatchesListResource::collection($query), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}

	/**
	*
	* Saved List
	*
	*/
	public function refreshMatches()
	{
		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError('',trans('customer_api.invalid_user'));
		}

		try{
			$result = [];
			// GET USER DATA
			$gender 	= ['Male'=>'Female','Female'=>'Male'];
			$anser_list = QuestionAnswer::where(['user_id'=>$user->id])->pluck('answer_id');

			$users 		= User::select('users.*')->join('question_answers as t2', 't2.user_id', '=', 'users.id')->whereIn('t2.answer_id', $anser_list)->where('users.gender', '=', $gender[$user->gender])->where('users.id', '!=', $user->id)->offset(0)->limit(1000)->get();
            if(count($users)>0){
				foreach($users as $list){
					$matches  = Matches::where(['user_id'=>$user->id, 'match_id'=>$list->id])->first();
					if(empty($matches)){

						// CREATE
						$result[] = Matches::create(['user_id'=>$user->id, 'match_id'=>$list->id, 'question_match'=>rand(1, 15)]);
					}
				}
				return $this->sendArrayResponse($result, trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
		}catch (\Exception $e) {
			return $this->sendError('', $e->getMessage());
		}
	}


}
