<?php

namespace App\Http\Controllers\theme;

use App\Http\Controllers\CommonController;
use App\Models\Helpers\CommonHelper;

use Illuminate\Http\Request;
use App\Http\Requests\UserbioRequest;
use App\Http\Requests\PartnerPreferenceRequest;
use Illuminate\Validation\ValidationException;
use Validator,Auth,DB,Storage;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\UserBio;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionAnswer;
use App\Models\ViewedMatchesHistory;
use App\Models\Interested;
use App\Models\Option;
use App\Models\Language;
use App\Models\City;
use App\Models\Friend;
use App\Models\State;
use App\Models\Matches;
use App\Models\PartnerPreference;
use App\Http\Resources\theme\BioDataResource;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use function Laravel\Prompts\select;

class ProfileController extends CommonController
{
	use CommonHelper;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	* Show the application profile page.
	*/
	public function profile(Request $request){

        $route_name = $request->route()->getName();

		$user = Auth()->user();
		if(empty($user)){
			header("Location: ". url('/')); exit;
		}

		try {
			$page       		= 'profile';
			$page_title 		= trans('title.profile');
			$viewed_matches		= ViewedMatchesHistory::where('user_id','=',$user->id)->count();
			$my_matches			= Matches::where('user_id','=',$user->id)->count();
            $interest           = Interested::where('user_id','=',$user->id)->count();
			$questions			= Question::where('questions.status', 'active')
                                    ->leftJoin('question_answers as t2', function ($join) use ($user) {
                                        $join->on('questions.id', '=', 't2.question_id')
                                            ->where('t2.user_id', '=', $user->id);
                                    })
                                    ->whereNull('t2.user_id')
                                    ->select('questions.*')
                                    ->get();
			$bio				= UserBio::where('user_id','=',$user->id)->first();

			$viewed_matches 	= $viewed_matches ? $viewed_matches : '0';
			$my_matches 		= $my_matches ? $my_matches : '0';
			$interested 		= $interest ? $interest : '0';
            $data               = [];

            if($bio){
                $data = [

                    'cast' => Option::where('id',$bio->cast)->pluck('title')->first(),
                    'religion' => Option::where('id',$bio->religion)->pluck('title')->first(),
                    'sub_cast' => Option::where('id',$bio->sub_cast)->pluck('title')->first(),
                    'community' => Option::where('id',$bio->community)->pluck('title')->first(),
                    'mother_tounge' => Option::where('id',$bio->mother_tongue)->pluck('title')->first(),
                    'family_type' => Option::where('id',$bio->family_type)->pluck('title')->first(),
                    'father_occupation' => Option::where('id',$bio->father_occupation)->pluck('title')->first(),
                    'city' => city::where('id',$bio->city)->pluck('name')->first(),
                    'marital_status' => Option::where('id',$bio->marital_status)->pluck('title')->first(),
                    'height' => Option::where('id',$bio->height)->pluck('title')->first(),
                    'highest_education' => Option::where('id',$bio->highest_qualificatin)->pluck('title')->first(),
                    'position' => Option::where('id',$bio->position)->pluck('title')->first(),
                    'income' => Option::where('id',$bio->income)->pluck('title')->first(),
                    'family_living_in' => city::where('id',$bio->family_living_in)->pluck('name')->first(),

                ];
            }

			foreach($questions as $key=> $list){
				$questions[$key]->options = QuestionOption::where(['question_id'=>$list->id])->get();
			}

			return view('theme/myAccount/profile', compact('page', 'page_title', 'user','questions','bio','viewed_matches','my_matches','interested','data'));

		} catch (Exception $e) {
		  return redirect()->back()->withError($e->getMessage());
		}
	}


	/**
	* Return json array.
	*/
	public function ajax_profile(){
		$user = Auth()->user();
		if (empty($user)) {
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		try {
			$bio = new BioDataResource(UserBio::where('user_id',$user->id)->first());

			return $this->sendResponse(trans('common.update_success'),$bio);

		} catch (Exception $e) {
		  $this->ajaxError($e->getMessage(),[]);
		}
	}

	/**
	*
	* Other User Profile
	*
	*/
	public function user_profile($id = 0){
		$user = Auth()->user();
		if(empty($user)){
			header("Location: ". url('/')); exit;
		}else if(empty($id)){
			header("Location: ". url('/')); exit;
		}

		try {

            //store as view match
            $this->save_viewed_match($id);

			$page       		= 'userProfile';
			$page_title 		= trans('title.user_profile');
			$user 				= User::where('id',$id)->first();
			$bio 				= UserBio::where('user_id',$id)->first();

            $data = [

                'cast' => Option::where('id',$bio?->cast)->pluck('title')->first(),
                'religion' => Option::where('id',$bio?->religion)->pluck('title')->first(),
                'sub_cast' => Option::where('id',$bio?->sub_cast)->pluck('title')->first(),
                'community' => Option::where('id',$bio?->community)->pluck('title')->first(),
                'mother_tounge' => Option::where('id',$bio?->mother_tounge)->pluck('title')->first(),
                'family_type' => Option::where('id',$bio?->family_type)->pluck('title')->first(),
                'father_occupation' => Option::where('id',$bio?->father_occupation)->pluck('title')->first(),
                'city' => city::where('id',$bio?->city)->pluck('name')->first(),
                'marital_status' => Option::where('id',$bio?->marital_status)->pluck('title')->first(),
                'height' => Option::where('id',$bio?->height)->pluck('title')->first(),
                'highest_education' => Option::where('id',$bio?->highest_qualificatin)->pluck('title')->first(),
                'position' => Option::where('id',$bio?->position)->pluck('title')->first(),
                'income' => Option::where('id',$bio?->income)->pluck('title')->first(),
                'family_living_in' => city::where('id',$bio?->family_living_in)->pluck('name')->first(),

            ];

			if(!empty($user)){
				return view('theme/myAccount/user-profile', compact('page', 'page_title', 'user', 'bio','data'));
			}

			header("Location: ". url('/profile')); exit;

		} catch (Exception $e) {
		  return redirect()->back()->withError($e->getMessage());
		}
	}

    /**
	* Show the application step page.
	*/
	public function complete_profile(Request $request,$step = 0){

		$user = Auth()->user();
		if(empty($user)){
			header("Location: ". url('/')); exit;
		}

		$options = [];

		if($step == 0){
			$options = [
				'religion' => Option::where('type','=','religion')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'mother_tongue' => Language::where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'community' => Option::where('type','=','community')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray()
			];

		}elseif($step == 1){
			$options = [
                'state' => State::where('status', 'active')->orderBy('name', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray(),
				'city' =>  City::where('status', 'active')->orderBy('name', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray(),
				'marital_status' => Option::where('type','=','marital_status')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'diet' => Option::where('type','=','diet')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'height' => Option::where('type','=','height')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
			];

		}elseif($step == 2){

			$options = [
				'highest_qualification' => Option::where('type','=','highest_qualification')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'position' => Option::where('type','=','company_position')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
                'diet' => Option::where('type','=','diet')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
			];

		}elseif($step == 3){

			$options = [
				'cast' => Option::where('type','=','cast')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'sub_cast' => Option::where('type','=','sub_cast')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'family_type' => Option::where('type','=','family_type')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'father_occupation' => Option::where('type','=','father_occupation')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
				'family_living_in' => City::where('status','active')->where('status','active')->orderBy('name', 'asc')->pluck('name','id')->toArray()
			];
		}

		try {
			$page       		= 'complete-profile';
			$page_title 		= trans('title.complete_profile');
			$data 				= UserBio::where('user_id',$user->id)->first();
			$data 				= UserBio::firstOrCreate(array('user_id' => $user->id));

			if($data){
				$data->day 		= '';
				$data->month 	= '';
				$data->year 	= '';
				if($user->dob){
					$data->day 		= date('d', strtotime($user->dob));
					$data->month 	= date('F', strtotime($user->dob));
					$data->year 	= date('Y', strtotime($user->dob));
				}
				$data->user			= $user;
			}
			return view('theme/myAccount/complete-profile', compact('page', 'page_title', 'data', 'step', 'options'));

		} catch (Exception $e) {
		  return redirect()->back()->withError($e->getMessage());
		}
	}
	/**
	*
	* Save Profile
	*
	*/
	public function post_complete_profile(Request $request){

        Log::info($request->city);

		if($request->step == ''){
			$this->ajaxError(trans('common.invalid_step'),[]);
		}

		$step = (int)$request->step;

		if($step === 0){

			$validator = Validator::make($request->all(), [
				'step' 				=> 'required',
				'first_name'   		=> 'required|max:51',
            	'last_name'     	=> 'required|max:51',
				'day'           	=> 'required|numeric|min:1|max:31',
            	'month'       		=> 'required|numeric|min:1|max:12',
            	'year'              => 'required|numeric|min:1980|max:2010',
				'religion'			=> 'required',
				'community'			=> 'required',
				'mother_tongue'		=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}

		}else if($step === 1){
			$validator = Validator::make($request->all(), [
                'state'             => 'required',
				'city' 				=> 'required',
				'live_with_family'	=> 'required',
				'marital_status'	=> 'required',
				'diet' 				=> 'required',
				'height'			=> 'required',
				'horoscope_require'	=> 'required',
				'manglik'			=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}
		}else if($step === 2){
			$validator = Validator::make($request->all(), [
				'highest_qualification'	=> 'required',
				'company_name'			=> 'required',
				'income_type'			=> 'required',
				'position' 				=> 'required',
				'income'				=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}
		}else if($step === 3){
			$validator = Validator::make($request->all(), [
				'cast'				=> 'required',
				'sub_cast'			=> 'required',
				'family_type'		=> 'required',
				'father_occupation'	=> 'required',
				'brother'			=> 'required',
				'sister'			=> 'required',
				'family_living_in'	=> 'required',
				'family_bio'		=> 'required',
				'address'			=> 'required',
				'contact_no'		=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}
		}else if($step === 4){
			$validator = Validator::make($request->all(), [
				'about'				=> 'required',
				'country_code'		=> 'required',
				'mobile_no'			=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}
		}else if($step === 5){
			$validator = Validator::make($request->all(), [
				'otp'				=> 'required',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}

			if($request->otp != '1111'){
				$this->ajaxError('Invalid OTP',[]);
			}
		}else if($step === 6){
			$validator = Validator::make($request->all(), [
				'profile_photo'				=> 'sometimes|image|mimes:jpeg,png,jpg,gif|max:1024',
				'cover_photo'				=> 'sometimes|image|mimes:jpeg,png,jpg,gif|max:1024',
			]);
			if($validator->fails()){
				$this->ajaxError($validator->errors()->first(),[]);
			}
		}else if($step === 7){
			$validator = Validator::make($request->all(), [
				'document_type'		=> 'required|max:3',
				'document_number'	=> 'required|max:32',
				'document'			=> 'sometimes|image|mimes:jpeg,png,jpg,gif|max:1024',
			]);
			if($validator->fails()){
				return $this->ajaxValidationError(trans('common.error'), $validator->errors());
			}
		}

		$user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

		$profileData  =  UserBio::where('user_id',$user->id)->first();
		if(empty($profileData)){
			UserBio::create(['user_id' => $user->id]);
		}

		DB::beginTransaction();
		try {

			$profileData  =  UserBio::where('user_id',$user->id)->first();
			if($profileData){

				if($step === 0){
					$user_data = [
						'first_name'		=>$request->first_name,
						'last_name'			=>$request->last_name,
						'dob'               => $request->year . '-' . $request->month . '-' . $request->day
					];

					User::where('id',$user->id)->update($user_data);

                    $dateOfBirth = Carbon::createFromFormat('Y-m-d', $user['dob']);
                    $age = $dateOfBirth->age;

					$data = [

						'religion' 		=> $request->religion,
						'community' 	=> $request->community,
						'mother_tongue'	=> $request->mother_tongue,
                        'age'           => $age
					];

				}else if($step === 1){
					$data = [
						'step' 				=> $step,
                        'state'             => $request->state,
                        'city' 				=> $request->city,
						'live_with_family'	=> $request->live_with_family,
						'marital_status'	=> $request->marital_status,
						'diet' 				=> $request->diet,
						'height'			=> $request->height,
						'horoscope_require'	=> $request->horoscope_require,
						'manglik'			=> $request->manglik,
					];
				}else if($step === 2){
					$data = [
						'step'					=> $step,
						'highest_qualificatin'	=> $request->highest_qualification,
						'company_name'			=> $request->company_name,
						'income_type'			=> $request->income_type,
						'position' 				=> $request->position,
						'income'				=> $request->income,
					];
				}else if($step === 3){
					$data = [
						'step'					=> $step,
						'cast'					=> $request->cast,
						'sub_cast'				=> $request->sub_cast,
						'family_type'			=> $request->family_type,
						'father_occupation'		=> $request->father_occupation,
						'brother'				=> $request->brother,
						'sister'				=> $request->sister,
						'family_living_in'		=> $request->family_living_in,
						'family_bio'			=> $request->family_bio,
						'family_address'		=> $request->address,
						'family_contact_no'		=> $request->contact_no,
					];
				}else if($step === 4){
					$data = [
						'step'			=> $step,
						'about'			=> $request->about,
						'country_code'	=> $request->country_code,
						'mobile_no'		=> $request->mobile_no,
					];
				}else if($step === 5){
					$data = [
						'step'			=> $step,
					];
				}else if($step === 6){
					if(!empty($request->profile_photo)){
						$profile_image = $this->saveMedia($request->file('profile_photo'));
						User::where('id',$user->id)->update(['profile_image' => $profile_image]);
					}else{
                        Log::info('existing profile photo');
                    }
                    // elseif(!empty($user->profile_image)){
                    //     Log::info('existing profile photo');
                    //     $profile_image = $this->saveMedia($user->profile_image);
					// 	User::where('id',$user->id)->update(['profile_image' => $profile_image]);
                    // }
					if(!empty($request->cover_photo)){
						$cover_image = $this->saveMedia($request->file('cover_photo'));
						User::where('id',$user->id)->update(['cover_image' => $cover_image]);
					}else{
                        Log::info('existing cover photo');
                    }
                    // elseif(!empty($user->cover_image)){
                    //     Log::info('existing cover photo');
                    //     $cover_image = $this->saveMedia($user->cover_image);
					// 	User::where('id',$user->id)->update(['cover_image' => $cover_image]);
                    // }
					$data['step'] =  $step;
				}else if($step === 7){
					$data = [
						'step'				=> $step,
						'document_type'		=> $request->document_type,
						'document_number'	=> $request->document_number,
					];
					if(!empty($request->document)){
						$data['document'] = $this->saveMedia($request->file('document'));
					}

					User::where('id',$user->id)->update(['step_complete' => $step]);
				}

				$profileData->fill($data);
				$return  =  $profileData->save();

				if($return){
					DB::commit();
					return $this->sendResponse(trans('common.saved_success'),[]);
				}
			}

			$this->ajaxError(trans('common.try_again'),[]);
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
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

    public function answer_question(Request $request)
    {
        Log::info($request);
        // $validator = Validator::make($request->all(), [
		// 	'answer_id'		=> 'sometimes|exists:question_options,id',
		// ]);

		// if($validator->fails()){
		// 	return $this->ajaxValidationError($validator->errors()->first(),'');
		// }

		DB::beginTransaction();
        try{

            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->ajaxError(trans('customer.invalid_user'),'');
            }

			//Get Answer Data
            $answer = QuestionOption::where('id',$request->answer_id)->first();
            if(empty($answer)){
                return $this->ajaxError(trans('customer.invalid_answer'),'');
            }

			$data = [
				'user_id'		=> $user->id,
				'question_id'	=> $answer->question_id,
				'answer_id'		=> $request->answer_id,
				'gender' 		=> $user->gender,
			];

            // store match

			// $qMatches = QuestionAnswer::all()->where("user_id", $user->id)->groupBy("answer_id", "question_id") ; //my qustions count
			// $saveMatchParams = [
			// 	'user_id'		 => $user->id,
			// 	'question_match' => $request->question_id,
			// 	'is_read' 		 => 0,
			// ];

			// $existInMatches = Matches::where(['user_id'=>$user->id])->first();
		    // if($existInMatches){
			// 	$query = Matches::where(['user_id'=>$user->id, 'question_match'=>$request->question_id])->update($data);
			// }else{
			// 	$query = Matches::create($saveMatchParams);
			// }

            // end store match

			$exist = QuestionAnswer::where(['user_id'=>$user->id, 'question_id'=>$answer->question_id])->first();
			if($exist){
                Log::info('edit success');
				$query = QuestionAnswer::where(['user_id'=>$user->id, 'question_id'=>$answer->question_id])->update($data);
			}else{
                Log::info('create success');
				$query = QuestionAnswer::create($data);
			}

			if($query){
				DB::commit();
                Log::info('final succesful');
				return redirect('/profile');
			}
			$this->ajaxError(trans('customer_api.try_again'),[]);
        }catch(\Exception $e){
            DB::rollback();
            $this->ajaxError(trans('customer_api.try_again'),[]);
        }
    }

    public function getLiveData(Request $request,$data){

        if($data === 'Yearly'){
            $response = Option::where('type','=','income_year')->where('status','active')->orderBy('title', 'asc')->select('title','id')->get();
        }elseif($data === 'Monthly'){
            $response = Option::where('type','=','income_month')->where('status','active')->orderBy('title', 'asc')->select('title','id')->get();
        }else{
            $response = City::where('status', 'active')->where('state_id', $data)->orderBy('name', 'asc')->select('name', 'id')->get();
        }
        return response()->json($response);
    }

    public function save_interest($id)
    {
        if(empty($id)){
            return $this->ajaxError(trans('user id is required'),'');
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->ajaxError(trans('invalid_user'),'');
        }

        DB::beginTransaction();
		try{
			$details = Interested::where(['user_id'=>$user->id, 'person_id'=>$id])->first();
			$check_interest = Interested::where(['user_id'=>$id, 'person_id'=>$user->id])->first();
			$is_friend = Friend::where(['user_id'=>$id, 'friend_id'=>$user->id])->first();
			if($details){
				DB::rollback();
                session()->flash('success', 'Interest sent already!');
                return redirect()->back();

			}elseif($is_friend){
                DB::rollback();
                session()->flash('info', 'friend already!');
                return redirect()->back();
            }elseif($check_interest){
				DB::rollback();
                session()->flash('warn', 'Recived interest!');
                return redirect()->back();
            }else{
				$data = [
					'user_id' 		 => $user->id,
					'person_id'		 => $id,
				];
				$query = Interested::create($data);
				if($query){
					DB::commit();
					//notify user
                    // $sendArray = [
                    // 	'user_id'   => $id,
                    // 	'title'		=> "Congratulations!",
                    // 	'body'		=> "Got interest from ".$user->name,
                    // 	'type'      => "request",
                    // 	'createNotification' => true
                    // ];

                    // $ns = new NotificationService;
                    // $ns->sendNotification( $sendArray );
                    session()->flash('success', 'Interest sent successfully!');
					return redirect()->back();
				}
			}

			DB::rollback();

			$this->ajaxError(trans('update_error'),'');
		}catch(\Exception $e){
            DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
        }
    }

    public function edit(){

        $user = Auth()->user();

		if(empty($user)){
			header("Location: ". url('/')); exit;
		}

        $options = [
            'religion' => Option::where('type','=','religion')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'mother_tongue' => Language::where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'community' => Option::where('type','=','community')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'state' => State::where('status', 'active')->orderBy('name', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray(),
            'city' =>  City::where('status', 'active')->orderBy('name', 'asc')->orderBy('name', 'asc')->pluck('name', 'id')->toArray(),
            'marital_status' => Option::where('type','=','marital_status')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'diet' => Option::where('type','=','diet')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'height' => Option::where('type','=','height')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'highest_qualification' => Option::where('type','=','highest_qualification')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'position' => Option::where('type','=','company_position')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'cast' => Option::where('type','=','cast')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'sub_cast' => Option::where('type','=','sub_cast')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'family_type' => Option::where('type','=','family_type')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'father_occupation' => Option::where('type','=','father_occupation')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'family_living_in' => City::where('status','active')->where('status','active')->orderBy('name', 'asc')->pluck('name','id')->toArray(),
            'yearly_income' => Option::where('type','=','income_year')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
            'monthly_income' => Option::where('type','=','income_month')->where('status','active')->orderBy('title', 'asc')->pluck('title','id')->toArray(),
        ];

		try {
			$page       		= 'complete-profile';
			$page_title 		= trans('title.complete_profile');
			$data 				= UserBio::where('user_id',$user->id)->first();
			$data 				= UserBio::firstOrCreate(array('user_id' => $user->id));

			if($data){
				$data->day 		= '';
				$data->month 	= '';
				$data->year 	= '';
				if($user->dob){
					$data->day 		= date('d', strtotime($user->dob));
					$data->month 	= date('F', strtotime($user->dob));
					$data->year 	= date('Y', strtotime($user->dob));
				}
				$data->user			= $user;
			}
			return view('theme/myAccount/edit-profile', compact('page', 'page_title', 'data', 'options', 'user'));

		} catch (Exception $e) {
		  return redirect()->back()->withError($e->getMessage());
		}
    }

    public function update(UserbioRequest $request){

        $user = Auth()->user();
		if(empty($user)){
			$this->ajaxError(trans('common.invalid_user'),[]);
		}

        DB::beginTransaction();
		try {

			$profileData  =  UserBio::where('user_id',$user->id)->first();
			if($profileData){

                $user_data = [
                    'first_name'		=>$request->first_name,
                    'last_name'			=>$request->last_name,
                    'name'				=>$request->first_name .' '. $request->last_name,
                    'email'				=>$request->email,
                    'phone_number'		=>$request->phone_number,
                    'dob'               => $request->dob,
                    'profile_image'     => $request->profile_iamge,
                    'cover_image'       => $request->cover_image
                ];

                User::where('id',$user->id)->update($user_data);

                $dateOfBirth = Carbon::createFromFormat('Y-m-d', $request->dob);
                $age = $dateOfBirth->age;

                $bio_data = [
                    'dob'                   => $request->dob,
                    'religion' 		        => $request->religion,
                    'community' 	        => $request->community,
                    'mother_tongue'	        => $request->mother_tongue,
                    'age'                   => $age,
                    'state'                 => $request->state,
                    'city' 				    => $request->city,
                    'live_with_family'	    => $request->live_with_family,
                    'marital_status'	    => $request->marital_status,
                    'diet' 				    => $request->diet,
                    'height'			    => $request->height,
                    'horoscope_require'	    => $request->horoscope_require,
                    'manglik'			    => $request->manglik,
                    'highest_qualificatin'	=> $request->highest_qualification,
                    'company_name'			=> $request->company_name,
                    'income_type'			=> $request->income_type,
                    'position' 				=> $request->position,
                    'income'				=> $request->income,
                    'cast'					=> $request->cast,
                    'sub_cast'				=> $request->sub_cast,
                    'family_type'			=> $request->family_type,
                    'father_occupation'		=> $request->father_occupation,
                    'brother'				=> $request->brother,
                    'sister'				=> $request->sister,
                    'family_living_in'		=> $request->family_living_in,
                    'family_bio'			=> $request->family_bio,
                    'family_address'		=> $request->family_address,
                    'family_contact_no'	    => $request->family_contact_no,
                    'about'			        => $request->about,
                    'country_code'	        => $request->country_code,
                    'mobile_no'		        => $request->mobile_no,
                    'document_type'		    => $request->document_type,
                    'document_number'	    => $request->document_number,
                    'document'              => $request->document,

                ];

                if(!empty($request->document)){
                    $this->saveMedia($request->file('document'));
                }

                if(!empty($request->hasFile('profile_image'))){
                    $profile_image = $this->saveMedia($request->file('profile_image'));
                    User::where('id',$user->id)->update(['profile_image' => $profile_image]);
                }else{
                    $profile_image = $user->profile_image;
                    User::where('id',$user->id)->update(['profile_image' => $profile_image]);
                }

                if(!empty($request->hasFile('cover_image'))){
                    $cover_image = $this->saveMedia($request->file('cover_image'));
                    User::where('id',$user->id)->update(['cover_image' => $cover_image]);
                }else{
                    $cover_image = $user->cover_image;
                    User::where('id',$user->id)->update(['cover_image' => $cover_image]);
                }

				$profileData->fill($bio_data);
				$return  =  $profileData->save();

				if($return){
					DB::commit();
					return redirect()->route('profile')->with('success', 'Your details updated successfully.');
				}
			}$this->ajaxError(trans('common.try_again'),[]);
		} catch (Exception $e) {
			DB::rollback();
			$this->ajaxError($e->getMessage(),[]);
		}
    }

    public function interest(){

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
                ->join('interested as t2','t2.person_id','users.id')
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

    public function ajax_interest_list (Request $request){

        $page       		= 'Interest';
        $page_title 		= trans('title.users.interest');
        $section            = $section ?? 'interest-receive-list';

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError(trans('customer_api.invalid_user'),'');
        }

        try{

            $details = [];

            if($section == 'interest-receive-list'){

                $details = Interested::join('users as t2','t2.id','interested.user_id')
                                    ->join('users_bio as t3', 't3.user_id', '=', 't2.id')
                                    // ->join('friends as t4', 't4.user_id', '=', 't2.id')
                                    ->where('interested.person_id',$user->id)
                                    // ->whereNot('t4.user_id',$user->id)
                                    // ->whereNot('t4.friend_id',$user->id)
                                    ->where('interested.status', 'pending')
                                    ->select('t2.*','interested.status','interested.person_id',)
                                    ->distinct()
                                    ->get();

                return $this->sendResponse(trans('common.data_found_success'),$details);

            }elseif($section == 'interest-send-list'){

                $interested_ids = Interested::join('users_bio as t2','interested.person_id','t2.user_id')
                ->where('interested.user_id',$user->id)
                // ->where('interested.status','pending')
                ->select('interested.person_id','t2.*')->get();

                foreach($interested_ids as $id){

                    $details [] = [
                        'id'            => $id->person_id,
                        'name'          => User::where('id',$id->person_id)->pluck('name')->first(),
                        'profile_image' => User::where('id',$id->person_id)->pluck('profile_image')->first(),
                        'age'           => UserBio::where('user_id',$id->person_id)->pluck('age')->first(),
                        'city'          => City::where('id',$id->city)->pluck('name')->first(),
                        'state'         => State::where('id',$id->state)->pluck('name')->first(),
                        'height'        => Option::where('id',$id?->height)->pluck('title')->first(),
                        'marital_status'=> Option::where('id',$id?->marital_status)->pluck('title')->first(),
                        'income'        => Option::where('id',$id?->income)->pluck('title')->first(),
                    ];
                }

                $this->sendResponse(trans('common.data_found_success'),$details);

            }elseif($section == 'interest-blocked-list'){

                $query	= User::select('users.*','t2.status','t2.person_id');

                //User Check
                $query->join('interested as t2', 't2.user_id', '=', 'users.id');
                $query->where(['t2.person_id'=>$user->id]);

                $details = $query->where('t2.status', 'blocked')->get();

                return $this->sendResponse(trans('common.data_found_success'),$details);
            }

		}catch(\Exception $e){
            return $this->ajaxError($e->getMessage(),[]);
        }
    }

    /**
	* Saved Partner Preference
	* @return \Illuminate\Http\Response
	*/
    public function save_partner_preference(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'height'			=> 'required',
            // 'marital_status'	=> 'required',
            'from_age'			=> 'required',
            'to_age'			=> 'required',
            'religion'			=> 'required',
            //'community'			=> 'required',
            'mother_tounge'		=> 'required',
            //'city_living_in'	=> 'required',
            //'qualification'		=> 'required',
            //'working_with'		=> 'required',
            //'profession_area'	=> 'required',
            //'income'			=> 'required',
            //'diet'				=> 'required',
            'looking_for'       => 'required'
        ]);

        if($validator->fails()){
            return $this->ajaxValidationError($validator->errors()->first(),'');
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->ajaxError(trans('customer_api.invalid_user'),'');
        }

        DB::beginTransaction();
		try{

			$data = [
				'user_id'			=> $user->id,
				// 'height'			=> $request->height,
				// 'marital_status'	=> $request->marital_status,
				'religion'			=> $request->religion,
				//'community'		=> $request->community,
				'start_age'			=> $request->from_age,
				'end_age'			=> $request->to_age,
				'mother_tongue'		=> $request->mother_tounge,
				// 'state_living_in'	=> $request->state_living_in,
				// 'city_living_in'	=> $request->city_living_in,
				// 'qualification'		=> $request->qualification,
				// 'working_with'		=> $request->working_with,
				// 'profession_area'	=> $request->profession_area,
				// 'income'			=> $request->income,
				// 'diet'				=> $request->diet,
                'looking_for'       => $request->looking_for,
			];

			// Get Data
			$details = PartnerPreference::where(['user_id'=>$user->id])->first();
			if($details){
				$query = PartnerPreference::where(['user_id'=>$user->id])->update($data);
				if($query){

					// User::where('id',$user->id)->update(['step_complete' => 7]);
					DB::commit();
					return $this->sendResponse(trans('customer_api.saved_success'),[]);
				}
			}else{
				$query = PartnerPreference::create($data);
				if($query){

					// User::where('id',$user->id)->update(['step_complete' => 7]);
					DB::commit();
					return $this->sendResponse(trans('customer_api.saved_success'),[]);
				}
			}

			DB::rollback();
			return $this->ajaxError(trans('customer_api.update_error'),'');
		}catch(\Exception $e){
            DB::rollback();
			return $this->ajaxError($e->getMessage(),[]);
        }
    }

    //save viewd matches
    public function save_viewed_match($id)
    {
        $user = Auth::user();
        if(empty($user)){
            return $this->sendError(trans('customer_api.invalid_user'),'');
        }

        DB::beginTransaction();
		try{
			$details = ViewedMatchesHistory::where(['user_id'=>$user->id, 'viewed_id'=>$id])->first();
			if($details){
				$details->last_view_date = date('Y-m-d');
				$details->last_view_time = date('H:i:s');
				$query = $details->update();
				if($query){
					DB::commit();
					return $this->sendResponse(trans('customer_api.saved_success'),[]);
				}
			}else{
				$data = [
					'user_id' 		 => $user->id,
					'viewed_id'		 => $id,
					'last_view_date' => date('Y-m-d'),
					'last_view_time' => date('H:i:s'),
				];
				$query = ViewedMatchesHistory::create($data);
				if($query){
					DB::commit();
					return $this->sendResponse(trans('customer_api.saved_success'),[]);
				}
			}

			DB::rollback();
			return $this->sendError(trans('customer_api.update_error'),'');
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError($e->getMessage(),[]);
        }
    }

}
