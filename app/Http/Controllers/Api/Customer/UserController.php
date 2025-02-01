<?php

namespace App\Http\Controllers\Api\Customer;

use Validator,DB;
use App\Services\NotificationService;
use Authy\AuthyApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Helpers\CommonHelper;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Friend;
use App\Models\DeviceDetail;
use App\Models\UserBio;
use App\Models\Question;
use App\Models\Article;
use App\Models\QuestionOption;
use App\Models\QuestionAnswer;
use App\Models\ViewedMatchesHistory;
use App\Models\Interested;
use App\Models\GalleryImage;
use App\Models\PartnerPreference;
use App\Models\CheckAppUpdate;

use App\Http\Resources\UserResource;
use App\Http\Resources\QuestionListResource;
use App\Http\Resources\DashboardDataResource;
use App\Http\Resources\MatchesListResource;
use App\Http\Resources\QuestionMatchesListResource;
use App\Http\Resources\BioDataResource;
use App\Http\Resources\GalleryImageResource;
use App\Http\Resources\SentInterestListResource;
use App\Http\Resources\ReceivedInterestListResource;
use App\Http\Resources\BlockedInterestListResource;
use App\Http\Resources\PartnerPreferenceResource;
use App\Http\Resources\OptionListResource;
use App\Models\Matches;

class UserController extends BaseController
{
	use CommonHelper;

    /**
     * GET PROFILE
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        DB::beginTransaction();
        try{

            //Get User Data
            $user_id = Auth::user()->id;
            if(empty($user_id)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }

            // GET USER DATA
            $user = User::where('id', $user_id)->first();
            
			if($user){
				$bio_data = UserBio::where('user_id',$user->id)->first();
				if($bio_data){
					$user->bio_data = new BioDataResource($bio_data);
				}else{
				    $user->bio_data = new BioDataResource(new UserBio());
				}
			}
            return $this->sendResponse(new UserResource($user), trans('customer_api.data_found_success'));
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	/**
     * PROFILE UPDATE
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:3|max:99',
            'gender'    => 'required|min:4|max:6',
            'dob'       => 'required',
            'phone_number' => 'required|min:6|max:15',
            'email'     => 'required|string|email|max:99',
            'country_code' => 'required|min:1|max:4',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user()->id;
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        // EMAIL VALIDATION
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendError('',trans('customer_api.invalid_email'));
        }

        // CHECK EMAIL EXIST OR NOT
        $email = User::where('email', $request->email)->whereNotIn('id', [$user])->first();
        if(!empty($email)){
            return $this->sendError('',trans('customer_api.email_already_exist'));
        }

        // CHECK MOBILE NO EXIST OR NOT
        $phone_number = User::where('phone_number', $request->phone_number)->whereNotIn('id', [$user])->first();
        if(!empty($phone_number)){
            return $this->sendError('',trans('customer_api.phone_number_already_exist'));
        }

        DB::beginTransaction();
		try{
			$query = User::where('id', $user)->update([
				'name'          => $request->name,
				'gender'        => $request->gender,
                'dob'           => date('Y-m-d', strtotime($request->dob)),
				'age'           => $request->age,
                'country_code'  => $request->country_code,
				'phone_number'  => $request->phone_number,
				'email'         => $request->email,
			]);
			if($query){
                DB::commit();

                //Get User Data
                $user = User::where('id', $user)->first();

                $success['id']               =  (string)$user->id;
                $success['gender']           =  $user->gender ? $user->gender : '';
                $success['age']              =  $user->dob ? (string) date_diff(date_create($user->dob), date_create('today'))->y : '';
                $success['dob']              =  $user->dob ? date('d-m-Y', strtotime($user->dob)) : '';
                $success['name']             =  $user->name;
                $success['email']            =  $user->email;
                $success['phone_number']     =  $user->phone_number;
                $success['status']           =  $user->status;
                $success['user_type']        =  $user->user_type;
				return $this->sendResponse($success, trans('customer_api.profile_update_success'));
			}else{
				DB::rollback();
				return $this->sendError('',trans('customer_api.profile_update_error'));
			}
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError('',trans('customer_api.profile_update_error'));
        }
    }

	/**
     * UPDATE PROFILE PICTURE
     * @return \Illuminate\Http\Response
	*/
    public function updateProfilePicture(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'image'	=> 'required|image|mimes:jpeg,png,jpg|max:1024',
		]);
		if($validator->fails()){
			return $this->sendValidationError('', $validator->errors()->first());
		}

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

		DB::beginTransaction();
		try{
			// Save Image
			if($request->image){
                $path = $this->saveMedia($request->file('image'));
				$query = User::where('id', $user->id)->update(['profile_image' => $path]);

				if($query){
					DB::commit();
					//Get User Data
					$user = User::where('id', $user->id)->first();
					return $this->sendResponse(new UserResource($user), trans('customer_api.update_success'));
				}else{
					DB::rollback();
					return $this->sendError('',trans('customer_api.update_error'));
				}
            }
			return $this->sendError('',trans('customer_api.update_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError('',$e);
        }
    }

	/**
     * UPDATE COVER IMAGE
     * @return \Illuminate\Http\Response
	*/
    public function updateCoverImage(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
		]);
		if($validator->fails()){
			return $this->sendError('', $validator->errors()->first());
		}

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			// Save Image
			if($request->image){
                $path = $this->saveMedia($request->file('image'));
				$query = User::where('id', $user->id)->update(['cover_image' => $path]);

				if($query){
					DB::commit();
					//Get User Data
					$user = User::where('id', $user->id)->first();
					return $this->sendResponse(new UserResource($user), trans('customer_api.update_success'));
				}else{
					DB::rollback();
					return $this->sendError('',trans('customer_api.update_error'));
				}
            }
			return $this->sendError('',trans('customer_api.update_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError('',$e);
        }
    }

	/**
     * UPLOAD GALLERY IMAGE
     * @return \Illuminate\Http\Response
	*/
    public function uploadGalleryImage(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
		]);
		if($validator->fails()){
			return $this->sendError('', $validator->errors()->first());
		}

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			// Save Image
			if($request->image){
                $path = $this->saveMedia($request->file('image'));

				$data = [
				  'user_id'	=> $user->id,
				  'image'	=> $path,
				];
				$query = GalleryImage::create($data);
				if($query){
					DB::commit();
					return $this->sendResponse(new GalleryImageResource($query), trans('customer_api.added_success'));
				}else{
					DB::rollback();
					return $this->sendError('',trans('customer_api.added_error'));
				}
            }
			return $this->sendError('',trans('customer_api.added_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError('',$e);
        }
    }

/**
     * GALLERY IMAGES
     * @return \Illuminate\Http\Response
	*/
    public function galleryImages(Request $request)
    {
		$user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        try{
			$data = GalleryImageResource::collection(GalleryImage::where(['user_id'=>$user->id])->get());
			if(count($data)>0){
				return $this->sendArrayResponse($data, trans('customer_api.data_found_sucess'));
			}
			return $this->sendArrayResponse([],trans('customer_api.data_found_empty'));
		}catch(\Exception $e){
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	/**
     * DELETE GALLERY IMAGE
     * @return \Illuminate\Http\Response
	*/
    public function deleteGalleryImage(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'id' => 'required|exists:gallery_images,id',
		]);
		if($validator->fails()){
			return $this->sendError('', $validator->errors()->first());
		}

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }
    
        DB::beginTransaction();
		try{
			$query = GalleryImage::where(['id'=>$request->id, 'user_id'=>$user->id])->delete();
			
			if($query){
				DB::commit();
				return $this->sendResponse([], trans('common.delete_success'));
			}
			return $this->sendResponse([], trans('common.delete_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError('',$e);
        }
    }

	/**
     * PROFILE BIO
     *
     * @return \Illuminate\Http\Response
     */
    public function update_bio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'religion'			=> 'required|min:1|max:11',
            //'community'			=> 'required|min:1|max:11',
            //'mother_tongue'		=> 'required|min:1|max:11',
            //'city'				=> 'required|min:1|max:11',
            //'family_type'		=> 'required',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			$array = [];
			if($request->dob){
				$age = (string) date_diff(date_create($request->dob), date_create('today'))->y;
				$array = array_merge($request->all(),['age' => $age]);
			}else{
				$array = $request->all();
			}

			$profileData  =  UserBio::where('user_id',$user->id)->first();
			if(empty($profileData)){
				UserBio::create(['user_id' => $user->id]);
			}

			$query = UserBio::where('user_id', $user->id)->update(
				array_filter($array, fn($value) => !is_null($value) && $value !== '')
			);

			if($query){
				DB::commit();
				return $this->sendResponse([], trans('customer_api.update_success'));
			}else{
				DB::rollback();
				return $this->sendError('',trans('customer_api.profile_update_error'));
			}
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError([], $e->getMessage());
        }
    }



	/**
	*
	* Save Profile
	*
	*/
	public function save_profile(Request $request){

		if($request->step == ''){
			// $this->ajaxError([], trans('common.invalid_step'));
			return $this->sendError([], trans('common.invalid_step'));
		}

		$step = (int)$request->step;

		if($step === 0){

			$validator = Validator::make($request->all(), [
				'step' 				=> 'required',
				'religion'			=> 'required',
				'community'			=> 'required',
				'mother_tongue'		=> 'required',
				// 'relation_type'		=> 'required',
                'day'           	=> 'required|numeric|min:1|max:31',
            	'month'       		=> 'required|numeric|min:1|max:12',
            	'year'              => 'required|numeric|min:1980|max:2010',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}

		}else if($step === 1){
			$validator = Validator::make($request->all(), [
                'step'              => 'required',
				'state' 			=> 'required',
				'city' 				=> 'required',
				'marital_status'	=> 'required',
				'height'			=> 'required',
				'diet' 				=> 'required',
				'manglik'			=> 'required',
				'live_with_family'	=> 'required',
				'horoscope_require'	=> 'required',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}else if($step === 2){
			$validator = Validator::make($request->all(), [
                'step'              => 'required',
				'highest_qualification'	=> 'required',
				// 'working_professional'	=> 'required',
				'company_name'		=> 'required',
				'income_type'		=> 'required',
				'income'			=> 'required',
				'position' 			=> 'required',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}else if($step === 3){
			$validator = Validator::make($request->all(), [
                'step'              => 'required',
				'cast'				=> 'required',
				'sub_cast'			=> 'required',
				'family_type'		=> 'required',
				'father_occupation'	=> 'required',
				'brother'			=> 'required',
				'sister'			=> 'required',
				'family_living_in'	=> 'required',
				'family_bio'		=> 'required',
				'family_address'	=> 'required',
				'family_contact_no'	=> 'required',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}else if($step === 4){
			$validator = Validator::make($request->all(), [
                'step'              =>'required',
				'about'				=> 'required',
				//'country_code'		=> 'required',
				//'mobile_no'			=> 'required',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}else if($step === 6){
			$validator = Validator::make($request->all(), [
            'step'                          =>'required',
				'profile_photo'				=> 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
				'cover_photo'				=> 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
				//'document_type'				=> 'required|max:21',
				//'document'					=> 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}else if($step === 7){
			$validator = Validator::make($request->all(), [
                'step'                      => 'required',
				'document_type'				=> 'required|max:21',
                'document_number'	        => 'required|max:32',
				'document'					=> 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
			]);
			if($validator->fails()){
				return $this->sendValidationError('', $validator->errors()->first());
			}
		}

		$user = Auth::user();

		if(empty($user)){
			// $this->ajaxError([], trans('common.invalid_user'));
			return $this->sendError([], trans('common.invalid_user'));
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
						'dob'           => $request->year . '-' . $request->month . '-' . $request->day
					];

					User::where('id',$user->id)->update($user_data);

                    $dateOfBirth = Carbon::createFromFormat('Y-m-d', $user_data['dob']);
                    $age = $dateOfBirth->age;

                    $data = [
                        'step'          => $request->step,
						'religion' 		=> $request->religion,
						'community' 	=> $request->community,
						'mother_tongue'	=> $request->mother_tongue,
						// 'relation_type'	=> $request->relation_type,
                        'age'           => $age,
					];

				}else if($step === 1){
					$data = [
						'step' 				=> $step,
						'state' 			=> $request->state,
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
						// 'working_professional'	=> $request->working_professional,
						'highest_qualificatin'	=> $request->highest_qualification,
						'company_name'			=> $request->company_name,
						'income_type'			=> $request->income_type,
						'income'				=> $request->income,
						'position' 				=> $request->position,
					];
				}else if($step === 3){
					$data = [
						'step'					=> $step,
						'cast'					=> $request->cast,
						'sub_cast'				=> $request->sub_cast,
						'family_type'			=> $request->family_type,
						// 'family_status'			=> $request->family_status,
						'father_occupation'		=> $request->father_occupation,
						'brother'				=> $request->brother,
						'sister'				=> $request->sister,
						'family_living_in'		=> $request->family_living_in,
						'family_bio'			=> $request->family_bio,
						'family_address'		=> $request->family_address,
						'family_contact_no'		=> $request->family_contact_no,
					];
				}else if($step === 4){
					$data = [
						'step'			=> $step,
						'about'			=> $request->about,
						//'country_code'	=> $request->country_code,
						//'mobile_no'		=> $request->mobile_no,
					];
				}else if($step === 6){
					if(!empty($request->profile_photo)){
						$profile_image = $this->saveMedia($request->file('profile_photo'));
						User::where('id',$user->id)->update(['profile_image' => $profile_image]);
					}
					if(!empty($request->cover_photo)){
						$cover_image = $this->saveMedia($request->file('cover_photo'));
						User::where('id',$user->id)->update(['cover_image' => $cover_image]);
					}

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
					$data['step'] =  $step;
				}

				User::where('id',$user->id)->update(['step_complete' => $step]);
				$profileData->fill($data);
				$return  =  $profileData->save();

				if($return){
					DB::commit();
					return $this->sendResponse([], trans('common.saved_success'));
				}
			}

			return $this->sendError([], trans('common.try_again'));
		} catch (Exception $e) {
			DB::rollback();
			// $this->ajaxError([], $e->getMessage());
			return $this->sendError([], $e->getMessage());
		}
	}

	/**
     * GET PROFILE
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard_data(Request $request)
    {
		$page   = $request->page ?? 1;
        $count  = $request->count ?? '100';

        if ($page <= 0){ $page = 1; }
        $offset = $count * ($page - 1);

        DB::beginTransaction();
        try{

            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }


			$gender = [ ];
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
			    if($user->gender == "Male"){
					$gender = ["Female"];
				} else {
					$gender = ["Male"];
				}
				// $gender = ["Male" => "Female", "Female" => "Male"];
			}


			$data['profile'] 				= new UserResource($user);

			// GET profile_completion
            $data['profile_completion']     = $this->calculate_profile() ?? "0";
            
			// GET Daily Matches
            $data['daily_matches'] 			= MatchesListResource::collection(User::where(['user_type'=>'Customer'])->where("id", "!=", $user->id)->whereIn('gender', $gender)->offset($offset)->limit(10)->inRandomOrder()->get());
			
			// GET Just Joined
            $data['question_matches']		= QuestionMatchesListResource::collection(Matches::select('t2.*')->join('users as t2', 't2.id', '=', 'matches.match_id')
			->whereIn('t2.gender' , $gender )
			->where('user_id', '=', $user->id)
			->groupBy('matches.match_id')
			->orderBy('matches.id', 'ASC')
			->offset($offset)
			->limit($count)
			->get());

			// GET Just Joined
            $data['just_joined'] 			= MatchesListResource::collection(User::where(['user_type'=>'Customer'])->where("id", "!=", $user->id)->whereIn('gender', $gender)->where('created_at', '>=', Carbon::now()->subDays(15))->offset($offset)->limit(10)->inRandomOrder()->get());


			return $this->sendResponse($data, trans('customer_api.data_found_success'));

        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	/**
     * GET PROFILE
     *
     * @return \Illuminate\Http\Response
     */
	public function check_app_update(Request $request)
    {
        try{
            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }

			$query = CheckAppUpdate::get()->map(function($element){
				$data = [];
				$data[$element->device]["is_update_available"] = $element->is_update_available ?? "";
				$data[$element->device]["current_version"] = $element->current_version ?? "";
				$data[$element->device]["new_version"] = $element->new_version ?? "";
				$data[$element->device]["url"] = $element->url ?? "";
				$data[$element->device]["is_force_update"] = $element->is_force_update ?? "";
				return $data;
			});


			return $this->sendArrayResponse($query, trans('customer_api.data_found_empty'));
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	public function get_articles(Request $request)
    {
        try{
            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }

			$query = Article::all();
            
			return $this->sendArrayResponse($query, trans('customer_api.data_found_success'));
        }catch(\Exception $e){
            
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }


	function calculate_profile()
	{

		$bio = Auth::user()->bio;


		if ( ! $bio) {
			return "0";
		} else {

		$bio->offsetUnset("gender");
		$bio->offsetUnset("community");
		// $bio->offsetUnset("state");
		$bio->offsetUnset("income_type");
		// $bio->offsetUnset("about");
		$bio->offsetUnset("mobile_no");
		$bio->offsetUnset("sexual_orientation");
		$bio->offsetUnset("vacation_destination");
		$bio->offsetUnset("residentail_status");

		$bio->offsetUnset("sun_sign");
		$bio->offsetUnset("position");
		$bio->offsetUnset("country_code");
		$bio->offsetUnset("ug_digree");
		$bio->offsetUnset("document");
		$bio->offsetUnset("rashi");
		$bio->offsetUnset("nakshtra");
		$bio->offsetUnset("document_type");
		$bio->offsetUnset("document_number");

		$bio->offsetUnset("horoscope_require");
		$bio->offsetUnset("manglik");
		$bio->offsetUnset("sub_cast");
		$bio->offsetUnset("family_bio");
		$bio->offsetUnset("family_address");
		$bio->offsetUnset("family_contact_no");
		$bio->offsetUnset("pg_digree");

		$bio->offsetUnset("highest_qualificatin");
		$bio->offsetUnset("working_professional");
		$bio->offsetUnset("gotra");
		$bio->offsetUnset("sub_gotra");
		$bio->offsetUnset("family_values");
		$bio->offsetUnset("pg_collage");
		$bio->offsetUnset("own_house");
		$bio->offsetUnset("own_car");
		$bio->offsetUnset("interest");

		$bio->offsetUnset("hiv");
		$bio->offsetUnset("thallassemia");
		$bio->offsetUnset("challenged");
		$bio->offsetUnset("tv_shows");
		$bio->offsetUnset("food_i_cook");
		$bio->offsetUnset("horoscope_privacy");


			$columns    = preg_grep('/(.+ed_at)|(.*id)/', array_keys($bio->toArray()), PREG_GREP_INVERT);
			//  dd($columns, preg_grep('/(.+ed_at)|(.*id)/',  ($bio->toArray()), PREG_GREP_INVERT));
			$per_column = 100 / count($columns);
			$total      = 0;

			foreach ($bio->toArray() as $key => $value) {
				if ($value !== NULL && $value !== [] && in_array($key, $columns)) {
					$total += $per_column;
				}
			}

			return (string)round($total);
		}


	}
	public function questions(Request $request)
    {
        try{
            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }

            // GET DATA
            $questions	= Question::where('status','active')->get();
			if(count($questions)>0){
				foreach($questions as $key=> $list){
					$questions[$key]->gender = $user->gender;
					$questions[$key]->options = QuestionOption::where(['question_id'=>$list->id])->get();
				}
				return $this->sendArrayResponse(QuestionListResource::collection($questions), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendError('',trans('customer_api.data_found_empty'));
        }
    }

	public function answer_question(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'question_id'	=> 'required|exists:questions,id',
			'answer_id'		=> 'sometimes|exists:question_options,id',
		]);
		if($validator->fails()){
			return $this->sendValidationError('', $validator->errors()->first());
		}

		DB::beginTransaction();
        try{

            //Get User Data
            $user = Auth::user();
            if(empty($user)){
                return $this->sendError('',trans('customer_api.invalid_user'));
            }

			//Get Answer Data
            $answer = QuestionOption::where('id',$request->answer_id)->first();
            if(empty($answer)){
                return $this->sendError('',trans('customer_api.invalid_answer'));
            }

			$data = [
				'user_id'		=> $user->id,
				'question_id'	=> $request->question_id,
				'answer_id'		=> $request->answer_id,
				'gender' 		=> $user->gender,
			];

			// $qMatches = QuestionAnswer::all()->where("user_id", $user->id)->groupBy("answer_id", "question_id") ; //my qustions count
			//  dd($qMatches->count());
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

			$exist = QuestionAnswer::where(['user_id'=>$user->id, 'question_id'=>$request->question_id])->first();
			if($exist){
				$query = QuestionAnswer::where(['user_id'=>$user->id, 'question_id'=>$request->question_id])->update($data);
			}else{
				$query = QuestionAnswer::create($data);
			}

			if($query){
				DB::commit();
				return $this->sendResponse([], trans('common.saved_success'));
			}
			return $this->sendError([], trans('customer_api.try_again'));
        }catch(\Exception $e){
            DB::rollback();
            return $this->sendError([], trans('customer_api.try_again'));
        }
    }

	/**
	* Save Viewed Matches History
	*
	* @return \Illuminate\Http\Response
	*/
    public function save_viewed_match(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'	=> 'required|exists:users,id',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			$details = ViewedMatchesHistory::where(['user_id'=>$user->id, 'viewed_id'=>$request->user_id])->first();
			if($details){
				$details->last_view_date = date('Y-m-d');
				$details->last_view_time = date('H:i:s');
				$query = $details->update();
				if($query){
					DB::commit();
					return $this->sendResponse([], trans('customer_api.saved_success'));
				}
			}else{
				$data = [
					'user_id' 		 => $user->id,
					'viewed_id'		 => $request->user_id,
					'last_view_date' => date('Y-m-d'),
					'last_view_time' => date('H:i:s'),
				];
				$query = ViewedMatchesHistory::create($data);
				if($query){
					DB::commit();
					return $this->sendResponse([], trans('customer_api.saved_success'));
				}
			}

			DB::rollback();
			return $this->sendError('',trans('customer_api.update_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError([], $e->getMessage());
        }
    }

	/**
	* Save Interest
	*
	* @return \Illuminate\Http\Response
	*/
    public function save_interest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'			=> 'required|exists:users,id',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			$details = Interested::where(['user_id'=>$user->id, 'person_id'=>$request->user_id])->first();
			if($details){
				DB::rollback();
				return $this->sendError('',trans('customer_api.already_saved'));
			}else{
				$data = [
					'user_id' 		 => $user->id,
					'person_id'		 => $request->user_id,
				];
				$query = Interested::create($data);
				if($query){
					DB::commit();
					//notify user
			// $sendArray = [
			// 	'user_id'   => $request->user_id,
			// 	'title'		=> "Congratulations!",
			// 	'body'		=> "Got interest from ".$user->name,
			// 	'type'      => "request",
			// 	'createNotification' => true
			// ];

			// $ns = new NotificationService;
			// $ns->sendNotification( $sendArray );
					return $this->sendResponse([], trans('customer_api.saved_success'));
				}
			}

			DB::rollback();

			return $this->sendError('',trans('customer_api.update_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError([], $e->getMessage());
        }
    }

	/**
	* Interest List
	*
	* @return \Illuminate\Http\Response
	*/
    public function sent_interestList(Request $request)
    {
		$page   	 = $request->page ?? 1;
		$count  	 = $request->count ?? '500';

		if ($page <= 0){ $page = 1; }
		$start = $count * ($page - 1);

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        try{
			$query	= User::select('users.*','t2.status','t2.person_id');

			//User Check
			$query->join('interested as t2', 't2.person_id', '=', 'users.id');
			$query->where('t2.user_id','=',$user->id);

			$details = $query->inRandomOrder()->offset($start)->limit($count)->get();
			if($details){
				return $this->sendArrayResponse(SentInterestListResource::collection($details), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
		}catch(\Exception $e){
            return $this->sendError([], $e->getMessage());
        }
    }

	/**
	* Interest List
	*
	* @return \Illuminate\Http\Response
	*/
    public function received_interestList(Request $request)
    {
		$page   	 = $request->page ?? 1;
		$count  	 = $request->count ?? '500';

		if ($page <= 0){ $page = 1; }
		$start = $count * ($page - 1);

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        try{

			$query	= User::select('users.*','t2.status','t2.person_id');

			//User Check
			$query->join('interested as t2', 't2.user_id', '=', 'users.id');
			$query->where(['t2.person_id'=>$user->id]);

			// Filters
			if($request->status){
				$query->where('t2.status', $request->status);
			}

			$details = $query->inRandomOrder()->offset($start)->limit($count)->get();
			if($details){
				return $this->sendArrayResponse(ReceivedInterestListResource::collection($details), trans('customer_api.data_found_success'));
			}
			return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
		}catch(\Exception $e){
            return $this->sendError([], $e->getMessage());
        }
    }

	/**
 * Blocked Interest List
 *
 * @return \Illuminate\Http\Response
 */
public function blocked_interestList(Request $request)
{
    $page = $request->page ?? 1;
    $count = $request->count ?? '100';

    if ($page <= 0) {
        $page = 1;
    }
    $start = $count * ($page - 1);

    $user = Auth::user();

    // Debugging: Check if user is authenticated
    if (empty($user)) {
        \Log::debug('Blocked Interest List: User is not authenticated');
        return $this->sendError('', trans('customer_api.invalid_user'));
    }

    // Debugging: Log user information
    \Log::debug('Blocked Interest List: Authenticated user details', ['user_id' => $user->id, 'email' => $user->email]);

    try {
        $query = User::select('users.*', 't2.status', 't2.person_id');

        // Debugging: Before joining the table
        \Log::debug('Blocked Interest List: Building query before join');

        // User Check
        $query->join('interested as t2', 't2.user_id', '=', 'users.id');
        $query->where(['t2.person_id' => $user->id]);

        // Debugging: After joining
        \Log::debug('Blocked Interest List: Query after join', ['query' => $query->toSql()]);

        $query->where('t2.status', 'blocked');

        // Fetch data
        $details = $query->inRandomOrder()->offset($start)->limit($count)->get();

        // Debugging: Log query results
        \Log::debug('Blocked Interest List: Query results', ['details' => $details]);

        if (count($details) > 0) {
            return $this->sendArrayResponse(BlockedInterestListResource::collection($details), trans('customer_api.data_found_success'));
        }

        return $this->sendArrayResponse([], trans('customer_api.data_found_empty'));
    } catch (\Exception $e) {
        // Debugging: Log exception
        \Log::error('Blocked Interest List: Exception occurred', ['message' => $e->getMessage()]);
        return $this->sendError([], $e->getMessage());
    }
}

	/**
	* Change Interest Status
	*
	* @return \Illuminate\Http\Response
	*/
    public function change_interestStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'		=> 'required',
            'status'	=> 'required',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			$details = Interested::where(['person_id'=>$user->id, 'user_id'=>$request->id])->first();
			if($details){
				if($request->status == 'accept'){
					$data = ['user_id' => $user->id, 'friend_id' => $request->id];
					$query = Friend::firstOrCreate($data);

					$data2 = ['friend_id' => $user->id, 'user_id' => $request->id];
					$query2 = Friend::firstOrCreate($data2);

					$query = Interested::where(['id'=>$details->id])->delete();
					if($query){
						DB::commit();
						// $sendArray = [
						// 	'user_id'   => $request->id,
						// 	'title'		=> "Congratulations!",
						// 	'body'		=> "Your request has been accepted by ".$user->name,
						// 	'type'      => "request",
						// 	'createNotification' => true
						// ];

						// $ns = new NotificationService;
						// $ns->sendNotification( $sendArray );
						return $this->sendResponse([], trans('common.saved_success'));
					}

				} else
				if($request->status == 'reject'){
					$query = Interested::where(['user_id'=>$request->id])->delete();

					if($query){
						DB::commit();
						return $this->sendResponse([], trans('common.deleted_success'));
					}
				}
				else{
					$details->fill(['status'=>$request->status]);
					$return = $details->save();
					if($return){
						DB::commit();

						return $this->sendResponse([], trans('common.saved_success'));
					}
				}
			}
			DB::rollback();
			return $this->sendError('',trans('customer_api.update_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError([], $e->getMessage());
        }
    }

	/**
	* Block Interest
	*
	* @return \Illuminate\Http\Response
	*/
    public function block_interest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'		=> 'required',
        ]);
        if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

        DB::beginTransaction();
		try{
			$details = Interested::where(['person_id'=>$user->id, 'user_id'=>$request->id])->first();
			if($details){
				$details->fill(['status'=>'blocked']);
				$return = $details->save();
				if($return){
					DB::commit();
					return $this->sendResponse([], trans('common.saved_success'));
				}
			}
			DB::rollback();
			return $this->sendError('',trans('customer_api.saved_error'));
		}catch(\Exception $e){
            DB::rollback();
			return $this->sendError([], $e->getMessage());
        }
    }

	public function send_notification(Request  $request){

		$validator = Validator::make($request->all(), [
			'user_id'   => 'required',
            'body'		=> 'required',
			'title'		=> 'required',
        ]);

		if($validator->fails()){
            return $this->sendValidationError('', $validator->errors()->first());
        }

        $user = Auth::user();
        if(empty($user)){
            return $this->sendError('',trans('customer_api.invalid_user'));
        }

		$ns = new NotificationService;
		$ns->sendNotification($request);
	}

	/**
	* Saved Partner Preference
	* @return \Illuminate\Http\Response
	*/
	public function savePartnerPreference(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'start_age' => 'required',
			'end_age' => 'required',
			'religion' => 'required',
			'mother_tongue' => 'required',
			'state_living_in' => 'required',
			'city_living_in' => 'required',
			'live_with_family' => 'required',
			'marital_status' => 'required',
			'diet' => 'required',
			'income' => 'required',
			'qualification' => 'required'
		]);
	
		if ($validator->fails()) {
			return $this->sendValidationError('', $validator->errors()->first());
		}
	
		$user = Auth::user();
		if (empty($user)) {
			return $this->sendError('', trans('customer_api.invalid_user'));
		}
	
		DB::beginTransaction();
		try {
			$data = [
				'user_id' => $user->id,
				'religion' => $request->religion,
				'start_age' => $request->start_age,
				'end_age' => $request->end_age,
				'mother_tongue' => $request->mother_tongue,
				'state_living_in' => $request->state_living_in,
				'city_living_in' => $request->city_living_in,
				'live_with_family' => $request->live_with_family,
				'marital_status' => $request->marital_status,
				'diet' => $request->diet,
				'income' => $request->income,
				'qualification' => $request->qualification
			];
	
			// Log the data being saved
			Log::info('Saving partner preference data:', $data);
	
			$details = PartnerPreference::where(['user_id' => $user->id])->first();
			if ($details) {
				// Update existing record
				$query = PartnerPreference::where(['user_id' => $user->id])->update($data);
				if ($query) {
					User::where('id', $user->id)->update(['step_complete' => 7]);
					DB::commit();
	
					// Log success
					Log::info('Partner preference updated successfully for user ID ' . $user->id);
	
					return $this->sendResponse($data, trans('customer_api.saved_success'));
				}
			} else {
				// Create new record
				$query = PartnerPreference::create($data);
				if ($query) {
					User::where('id', $user->id)->update(['step_complete' => 7]);
					DB::commit();
	
					// Log success
					Log::info('Partner preference created successfully for user ID ' . $user->id);
	
					return $this->sendResponse($data, trans('customer_api.saved_success'));
				}
			}
	
			DB::rollback();
			return $this->sendError('', trans('customer_api.update_error'));
		} catch (\Exception $e) {
			DB::rollback();
	
			// Log the exception
			Log::error('Error saving partner preference for user ID ' . $user->id . ': ' . $e->getMessage());
	
			return $this->sendError([], $e->getMessage());
		}
	}

	/**
 * Get Partner Preference List
 * @return \Illuminate\Http\Response
 */
public function partnerPreferences(Request $request)
{
    $user = Auth::user();
    if (empty($user)) {
        return $this->sendError('', trans('customer_api.invalid_user'));
    }

    try {
        // Get Data
        $details = PartnerPreference::where(['user_id' => $user->id])->first();
        
        if ($details) {
            // Log the details (optional)
            \Log::info('Partner Preference Details:', ['user_id' => $user->id, 'details' => $details]);

            return $this->sendResponse(new PartnerPreferenceResource($details), trans('customer_api.data_found_success'));
        }

        // Log that no data was found (optional)
        \Log::info('No Partner Preference found for user:', ['user_id' => $user->id]);

        return $this->sendResponse([], trans('customer_api.data_found_empty'));
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error fetching Partner Preference:', ['user_id' => $user->id, 'error' => $e->getMessage()]);

        return $this->sendError([], $e->getMessage());
    }
}

}
