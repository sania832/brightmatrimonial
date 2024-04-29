<?php

namespace App\Http\Controllers\theme;

use Auth,App;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Http\Resources\MatchesListResource;
use App\Models\Option;
use App\Models\UserBio;
use App\Models\Matches;
use App\Models\City;
use App\Models\State;
use App\Models\QuestionAnswer;
use App\Models\ViewedMatchesHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Validator,DB,Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use function Laravel\Prompts\search;

class MatchController extends CommonController
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
			$page       	= 'matchPage';
			$page_title 	= trans('title.matches');

			return view('theme.matches.index', compact('page','page_title'));
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}


	/**
	*
	* SEARCH PAGE
	*
	*/
	public function search(Request $request)
	{

		try {
			$page       	= 'searchMatchesPage';
			$page_title 	= trans('title.search_matches');

            $options = [
                'relationship_type' => Option::where('type','=','relation_type')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'height' => Option::where('type','=','height')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'religion' => Option::where('type','=','religion')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'cast' => Option::where('type','=','cast')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'marital_status' => Option::where('type','=','marital_status')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'income' => Option::where('type','=','income_year')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'sexual_orientation' => Option::where('type','=','sexual_orientation')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray()
            ];

			return view('theme.matches.search', compact('page','page_title','options'));
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}

	/**
	*
	* GET LIST
	*
	*/
	public function ajax(Request $request,$id = null){

        //Get User Data
		$search = $request->search;
		$type 	= $request->type ?? 'daily-recomodation-list';
        $page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError(trans('customer_api.invalid_user'),'');
		}

		try{
			// GET LIST

            $gender = [];
			if($user->bio->relation_type == "2") { // LGBTQ
				$gender = ["Female", "Male"];
			} else if($user->bio->relation_type == "3") { //Heterosexual
				if($user->gender == "Male"){
					$gender = ["Female"];
				} else {
					$gender = ["Male"];
				}
			} else if($user->bio->relation_type == "4") { //Asexual
				if($user->gender == "Male"){
					$gender = ["Male"];
				} else {
					$gender = ["Female"];
				}
			} else if($user->bio->relation_type == "5"){ //Bisexual
					 $gender = ["Female", "Male"];
			} else {
				$gender = ["Male" => "Female", "Female" => "Male"];
			}

            if($request?->section == 'search-list'){

                $validator = Validator::make($request->all(), [
                    'age_from'          => 'required_with:age_to',
                    'age_to'            => 'required_with:age_from',
                    'income_from'       => 'required_with:income_to',
                    'income_to'         => 'required_with:income_from',
                ]);

                if($validator->fails()){
                    return $this->ajaxValidationError(trans('common.error'), $validator->errors());
                }

                $query = User::join('users_bio', 'users.id', '=', 'users_bio.user_id')
                                ->where('users.user_type','=','Customer')
                                ->where('users.id', '!=', $user->id);

                // $filters = [
                //     'height',
                //     'religion',
                //     'cast',
                //     'marital_status',
                //     'relationship_type' => 'marital_status',
                //     'sexual_orientation',
                // ];

                // foreach ($filters as $filter => $column) {
                //     if ($request->$filter) {
                //         $query->where($column ?? $filter, $request->$filter);
                //     }
                // }
                if($request->height){
                    $query->where('users_bio.height',$request->height);
                }

                if($request->religion){
                    $query->where('users_bio.religion',$request->religion);
                }

                if($request->cast){
                    $query->where('users_bio.cast',$request->cast);
                }

                if($request->marital_status){
                    $query->where('users_bio.marital_status',$request->marital_status);
                }

                if ($request->age_from && $request->age_to) {
                    $query->whereBetween('age', [$request->age_from, $request->age_to]);
                }

                if ($request->income_from && $request->income_to) {
                    $query->whereBetween('income', [$request->income_from, $request->income_to]);
                }

                $data = $query->select('users.*')->get();

            }elseif($request?->section == 'daily-recomodation-list'){

                $data = User::where(['user_type'=>'Customer'])
                ->where("id", "!=", $user->id)
                ->whereIn('gender', $gender)
                ->get();

            }elseif($request?->section == 'question-match-list'){

                $this->refreshMatches();
                $data = Matches::select('t2.*')->join('users as t2', 't2.id', '=', 'matches.match_id')
												->whereIn('t2.gender' , $gender )
												->where('user_id', '=', $user->id)
												->get();

            }elseif($request?->section == 'just-joined-list'){

                $data = User::where(['user_type'=>'Customer'])
                ->whereIn('gender', $gender)
                ->where("id", "!=", $user->id)
                ->where('created_at', '>=', Carbon::now()
                ->subDays(15))
                ->get();

            }elseif($request?->section == 'viwed-matches-list'){
                $data = User::where(['user_type'=>'Customer'])
                ->join('viewed_matches_history as t2','t2.viewed_id','users.id')
                ->where('t2.user_id',$user->id)
                ->whereIn('users.gender', $gender)
                // ->where("users.id", "!=", $user->id)
                ->get('users.*');

            }

            $matche_list = [];

            foreach($data as $user){

                $matche_list [] =  [
                    'id'            => (string) $user->id,
                    'image'       	=> $user->profile_image ? (string) asset($user->profile_image) : asset(config('constants.DEFAULT_THUMBNAIL')),
                    'name'       	=> $user->name ? (string) $user->name : '',
                    'age'   		=> $user->bio && $user->bio?->age ? $user->bio?->age : 'Age not specified',
                    'city'          => $user->bio && $user->bio->city ? city::where('id',$user->bio->city)->pluck('name')->first() : "City not specified",
                    'state'         => $user->bio && $user->bio->state ? State::where('id',$user->bio->state)->pluck('name')->first() : "State not specified",
                    'height'        => $user->bio && $user->bio->height ? Option::where('id',$user->bio->height)->pluck('title')->first() : "Height not specified",
                    'marital_status'=> $user->bio && $user->bio->marital_status ? Option::where('id',$user->bio->marital_status)->pluck('title')->first() : "Marital status not specified",
                    'income'        => $user->bio && $user->bio->income ? Option::where('id',$user->bio->income)->pluck('title')->first() : "Income not specified",
                ];
            }

            if($matche_list){
				return $this->sendResponse(trans('common.data_found_success'),$matche_list);
			}
			return $this->sendResponse(trans('common.data_found_empty'),[]);

		} catch (Exception $e) {
			return $this->ajaxError($e->getMessage(),[]);
		}

	}

    public function refreshMatches()
	{
		//Get User Data
		$user = Auth::user();
		if(empty($user)){
			return $this->sendError(trans('customer_api.invalid_user'),'');
		}

		try{
			$result = [];

			// GET USER DATA
			$gender 	= ['Male'=>'Female','Female'=>'Male'];
            $answer_list = QuestionAnswer::where('user_id','=',$user->id)->pluck('answer_id');

			$users 		= User::select('users.*')
            ->join('question_answers as t2', 't2.user_id', '=', 'users.id')
            ->whereIn('t2.answer_id', $answer_list)
            ->where('users.gender', '=', $gender[$user->gender])
            ->where('users.id', '!=', $user->id)
            ->get('users.id');

            if(count($users)>0){
				foreach($users as $list){
					$matches  = Matches::where('user_id','=',$user->id)->where('match_id','=',$list->id)->first();
					if(empty($matches)){
						// CREATE
						$result[] = Matches::create(['user_id'=>$user->id, 'match_id'=>$list->id, 'question_match'=>rand(1, 15)]);
					}
				}
				return $this->sendResponse(trans('customer_api.data_found_success'),$result);
			}
			return $this->sendResponse(trans('customer_api.data_found_empty'),[]);
		}catch (\Exception $e) {
			return $this->sendError($e->getMessage(),'');
		}
	}

    public function viwedMatches()
	{

		try {
			$page       	= 'viewed matches';
			$page_title 	= trans('title.viwed matches');

            $user = Auth::user();
            $data = [];

            $gender = [];
			if($user->bio->relation_type == "2") { // LGBTQ
				$gender = ["Female", "Male"];
			} else if($user->bio->relation_type == "3") { //Heterosexual
				if($user->gender == "Male"){
					$gender = ["Female"];
				} else {
					$gender = ["Male"];
				}
			} else if($user->bio->relation_type == "4") { //Asexual
				if($user->gender == "Male"){
					$gender = ["Male"];
				} else {
					$gender = ["Female"];
				}
			} else if($user->bio->relation_type == "5"){ //Bisexual
					 $gender = ["Female", "Male"];
			} else {
				$gender = ["Male" => "Female", "Female" => "Male"];
			}

            $query = User::where(['user_type'=>'Customer'])
                ->join('viewed_matches_history as t2','t2.viewed_id','users.id')
                ->where('t2.user_id',$user->id)
                ->whereIn('users.gender', $gender)
                ->get('users.*');

            foreach($query as $user){
                $data [] =  [
                    'id'            => (string) $user->id,
                    'image'       	=> $user->profile_image ? (string) asset($user->profile_image) : asset(config('constants.DEFAULT_THUMBNAIL')),
                    'name'       	=> $user->name ? (string) $user->name : '',
                    'age'   		=> $user->bio?->age ?? '',
                    'city'          => city::where('id',$user->bio->city)->pluck('name')->first(),
                    'state'         => State::where('id',$user->bio->state)->pluck('name')->first(),
                    'height'        => Option::where('id',$user->bio->height)->pluck('title')->first(),
                    'marital_status'=> Option::where('id',$user->bio->marital_status)->pluck('title')->first(),
                    'income'        => Option::where('id',$user->bio->income)->pluck('title')->first(),
                ];
            }

            return view('theme.matches.viewed-matches', compact('page','page_title','data'));
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
	}

    // matches according to partner preferences
    public function yourMatch(){

        try {
			$page       	= 'Interest';
			$page_title 	= trans('title.users.interest');
            $data           = [];

            $user = Auth::user();

            $gender = [];
			if($user->bio->relation_type == "2") { // LGBTQ
				$gender = ["Female", "Male"];
			} else if($user->bio->relation_type == "3") { //Heterosexual
				if($user->gender == "Male"){
					$gender = ["Female"];
				} else {
					$gender = ["Male"];
				}
			} else if($user->bio->relation_type == "4") { //Asexual
				if($user->gender == "Male"){
					$gender = ["Male"];
				} else {
					$gender = ["Female"];
				}
			} else if($user->bio->relation_type == "5"){ //Bisexual
					 $gender = ["Female", "Male"];
			} else {
				$gender = ["Male" => "Female", "Female" => "Male"];
			}

            $query = User::where(['user_type'=>'Customer'])
                ->join('matches as t2','t2.match_id','users.id')
                ->where('t2.user_id',$user->id)
                ->whereIn('users.gender', $gender)
                ->select('users.*')
                ->get();

            if($query){
                foreach($query as $user){
                    $data [] =  [
                        'id'            => (string) $user->id,
                        'image'       	=> $user->profile_image ? (string) asset($user->profile_image) : asset(config('constants.DEFAULT_THUMBNAIL')),
                        'name'       	=> $user->name ? (string) $user->name : '',
                        'age'   		=> $user->bio?->age ?? '',
                        'city'          => city::where('id',$user->bio->city)->pluck('name')->first(),
                        'state'         => State::where('id',$user->bio->state)->pluck('name')->first(),
                        'height'        => Option::where('id',$user->bio->height)->pluck('title')->first(),
                        'marital_status'=> Option::where('id',$user->bio->marital_status)->pluck('title')->first(),
                        'income'        => Option::where('id',$user->bio->income)->pluck('title')->first(),
                    ];
                }
            }

            return view('theme.matches.viewed-matches', compact('page','page_title','data'));
		} catch (Exception $e) {
			return redirect()->back()->withError($e->getMessage());
		}
    }

}
