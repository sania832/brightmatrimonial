<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Auth;
use App\Models\Option;
use App\Models\Language;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Models\Interested;
use App\Models\Friend;
use App\Models\Matches;

class BioDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /* STATIC DATA */
    public function toArray($request)
    {
        // dd($this->position);
		$user = Auth::user();
		// dd("dolly",$this->user_id, "harpal",$user->id);
		// Realtion Details
		$question_match			= Matches::where(['match_id'=>$this->user_id, 'user_id'=>Auth::user()->id])->pluck('question_match')->first();
		$is_friend 				= Friend::where(['friend_id'=>$this->user_id])->where("user_id", $user->id)->count();
		// dd($is_friend);
		$is_request_sent 		= Interested::where(['person_id'=>$this->user_id, 'user_id'=>Auth::user()->id])->count();
		$is_request_received	= Interested::where(['person_id'=>Auth::user()->id, 'user_id'=>$this->user_id])->count();
		$is_blocked				= Interested::where(['person_id'=>Auth::user()->id, 'user_id'=>$this->user_id, 'status'=>'blocked'])->count();
		if($is_friend == 1){ $is_request_sent = '0'; $is_request_received = '0'; $is_blocked = '0'; }

		$community 				= Option::where('id','=',$this->community)->pluck('title')->first();
		$mother_tongue 			= Option::where('id','=',$this->mother_tongue)->pluck('title')->first();
		$city 					= City::where('id','=',$this->city)->pluck('name')->first();
		$state 					= State::where('id','=',$this->state)->pluck('name')->first();
		$income 				= Option::where('id','=',$this->income)->pluck('title')->first();
		$position 				= Option::where('id','=',$this->position)->pluck('title')->first();
		$religion				= Option::where('id','=',$this->religion)->pluck('title')->first();
		$cast 					= Option::where('id','=',$this->cast)->pluck('title')->first();	
		$sub_cast				= Option::where('id','=',$this->sub_cast)->pluck('title')->first();

		$father_occupation		= Option::where('id','=',$this->father_occupation)->pluck('title')->first();
		$family_living_in		= City::where('id','=',$this->family_living_in)->pluck('name')->first();
		$family_type			= Option::where('id','=',$this->family_type)->pluck('title')->first();

		$sexual_orientation		= Option::where('id','=',$this->sexual_orientation)->pluck('title')->first();
		$interest				= Option::where('id','=',$this->interest)->pluck('title')->first();
		$ug_digree				= Option::where('id','=',$this->ug_digree)->pluck('title')->first();
		$pg_digree				= Option::where('id','=',$this->pg_digree)->pluck('title')->first();
		$highest_qualification	= Option::where('id','=',$this->highest_qualificatin)->pluck('title')->first();
		$occupation				= Option::where('id','=',$this->occupation)->pluck('title')->first();
		$company_position		= Option::where('id','=',$this->position)->pluck('title')->first();

		// Hobbies
		$hobbies				= OptionListResource::collection(Option::whereIn('id', explode(',', $this->hobbies))->get());
		$favorite_music			= OptionListResource::collection(Option::whereIn('id', explode(',', $this->favorite_music))->get());
		$favorite_books			= OptionListResource::collection(Option::whereIn('id', explode(',', $this->favorite_books))->get());
		$dress_style			= OptionListResource::collection(Option::whereIn('id', explode(',', $this->dress_style))->get());
		$favorite_movies		= OptionListResource::collection(Option::whereIn('id', explode(',', $this->favorite_movies))->get());
		$favorite_sports		= OptionListResource::collection(Option::whereIn('id', explode(',', $this->favorite_sports))->get());
		$cuisine				= OptionListResource::collection(Option::whereIn('id', explode(',', $this->cuisine))->get());
		$vacation_destination	= OptionListResource::collection(Option::whereIn('id', explode(',', $this->vacation_destination))->get());

		/* Horoscope*/
		$sun_sign				= Option::where('id','=',$this->sun_sign)->pluck('title')->first();
		$rashi					= Option::where('id','=',$this->rashi)->pluck('title')->first();
		$nakshtra				= Option::where('id','=',$this->nakshtra)->pluck('title')->first();
		$horoscope_privacy		= Option::where('id','=',$this->horoscope_privacy)->pluck('title')->first();
		$gotra					= Option::where('id','=',$this->gotra)->pluck('title')->first();
		$sub_gotra				= Option::where('id','=',$this->sub_gotra)->pluck('title')->first();

		$dob					= User::where('id','=',$this->user_id)->pluck('dob')->first();
		//$tob					= User::where('id','=',$this->user_id)->pluck('tob')->first();
		$diet					= Option::where('id','=',$this->diet)->pluck('title')->first();
		$height					= Option::where('id','=',$this->height)->pluck('title')->first();
		$relation_type			= Option::where('id','=',$this->relation_type)->pluck('title')->first();
		$marital_status			= Option::where('id','=',$this->marital_status)->pluck('title')->first();
		$languages				= Language::where('id','=',$this->languages)->pluck('title')->first();
		$blood_group			= Option::where('id','=',$this->blood_group)->pluck('title')->first();
		$tv_shows				= Option::where('id','=',$this->tv_shows)->pluck('title')->first();
		$mother_occupation		= Option::where('id','=',$this->mother_occupation)->pluck('title')->first();
		$gender					= User::where('id','=',$this->user_id)->pluck('gender')->first();
		$user_type			    = User::where('id','=',$this->user_id)->pluck('user_type')->first();
        $contact_number         = User::where('id','=',$this->user_id)->pluck('phone_number')->first();

		// return parent::toArray($request);
		return [
            'id'                		=> (string) $this->id,
            'user_id'                   => (string) $this->user_id,
            'religion'             		=> $religion ? $religion : '',
            'gender'             		=> $gender ? $gender : '',
            'community'					=> $community ? $community : '',
            'mother_tongue'             => $mother_tongue ? $mother_tongue : '',
            'state'             		=> $state ? $state : '',
            'city'             			=> $city ? $city : '',
            'live_with_family'			=> $this->live_with_family ? $this->live_with_family : '',
            'marital_status'			=> $marital_status ? $marital_status : '',
            'diet'						=> $diet ? $diet : '',
            'height'					=> $height ? $height : '',
            'user_type'					=> $user_type ? $user_type : '',
            'horoscope_require'			=> $this->horoscope_require ? $this->horoscope_require : '',
            'manglik'					=> $this->manglik ? $this->manglik : '',
            'highest_qualification'		=> $highest_qualification ? $highest_qualification : '',
            'company_name'				=> $this->company_name ? $this->company_name : '',
            'income_type'				=> $this->income_type ? $this->income_type : '',
            'income'					=> $income ? $income : '',
            // 'position'					=> $position ? $position : '',
            'cast'						=> $cast ? $cast : '',
            'sub_cast'					=> $sub_cast ? $sub_cast : '',

			/* Family Details */
			'family_type'				=> $family_type ? $family_type : '',
            'father_occupation'			=> $father_occupation ? $father_occupation : '',
            'brother'					=> $this->brother ? $this->brother : '0',
            'sister'					=> $this->sister ? $this->sister : '0',
            'family_living_in'			=> $family_living_in ? $family_living_in : '',
            'family_bio'				=> $this->family_bio ? $this->family_bio : '',
            'family_address'			=> $this->family_address ? $this->family_address : '',
            'family_contact_no'			=> $this->family_contact_no ? $this->family_contact_no : '',
            'about'						=> $this->about ? $this->about : '',

			// 'country_code'				=> $this->country_code ? $this->country_code : '',
            'mobile_no'					=> $contact_number  ? $contact_number  : '',
            'document_type'				=> ($this->document_type == 1) ? 'Pan Card' : (($this->document_type == 2) ? 'Voter Card' : (($this->document_type == 3) ? 'Driving License' : '')),
            'document_number'			=> $this->document_number  ? $this->document_number  : '',
            'document'					=> $this->document ? (string) asset('bright-metromonial/public/'. $this->document) : asset('default/default_document.webp'),

			'sexual_orientation'		=> $sexual_orientation ? $sexual_orientation : '',
			// 'interest'					=> $interest ? $interest : '',
			// 'ug_digree'					=> $ug_digree ? $ug_digree : '',
			// 'pg_digree'					=> $pg_digree ? $pg_digree : '',
			'highest_qualification'		=> $highest_qualification ? $highest_qualification : '',
			'occupation'				=> $occupation ? $occupation : '',
			'company_position'			=> $company_position ? $company_position : '',
			// 'working_professional'		=> $this->working_professional ? $this->working_professional : '',

			// Hobbies
			'hobbies'					=> $hobbies ? $hobbies : '',
			'favorite_music'			=> $favorite_music ? $favorite_music : [],
			'favorite_books'			=> $favorite_books ? $favorite_books : [],
			'dress_style'				=> $dress_style ? $dress_style : [],
			'favorite_movies'			=> $favorite_movies ? $favorite_movies : [],
			'favorite_sports'			=> $favorite_sports ? $favorite_sports : [],
			'cuisine'					=> $cuisine ? $cuisine : '',
			'vacation_destination'		=> $vacation_destination ? $vacation_destination : [],

			// 'sun_sign'					=> $sun_sign ? $sun_sign : '',
			// 'rashi'						=> $rashi ? $rashi : '',
			// 'nakshtra'					=> $nakshtra ? $nakshtra : '',

			'profile_handler'			=> $this->profile_handler ? $this->profile_handler : '',
			// 'gotra'						=> $gotra ? $gotra : '',
			// 'sub_gotra'					=> $sub_gotra ? $sub_gotra : '',
			// 'family_values'				=> $this->family_values ? $this->family_values : '',
			'mother_occupation'			=> $mother_occupation ? $mother_occupation : '',
			'relation_type'				=> $relation_type ? $relation_type : '',
			'ug_collage'				=> $this->ug_collage ? $this->ug_collage : '',
			// 'pg_collage'				=> $this->pg_collage ? $this->pg_collage : '',
			'drinking_habits'			=> $this->drinking_habits ? $this->drinking_habits : '',
			'smoking_habits'			=> $this->smoking_habits ? $this->smoking_habits : '',
			'open_to_pates'				=> $this->open_to_pates ? $this->open_to_pates : '',
			// 'own_house'					=> $this->own_house ? $this->own_house : '',
			// 'own_car'					=> $this->own_car ? $this->own_car : '',
			'residentail_status'		=> $this->residentail_status ? $this->residentail_status : '',
			'languages'					=> $languages ? $languages : '',
			'blood_group'				=> $blood_group ? $blood_group : '',
			// 'hiv'						=> $this->hiv ? $this->hiv : '',
			// 'thallassemia'				=> $this->thallassemia ? $this->thallassemia : '',
			// 'challenged'				=> $this->challenged ? $this->challenged : '',
			'place_of_birth'			=> $this->place_of_birth ? $this->place_of_birth : '',
			'date_of_birth'				=> $dob ? (string)$dob : '',
			'tob'						=> $this->tob ? (string)$this->tob : '',
			'age'						=> $this->age ? (string)$this->age : '',
			// 'tv_shows'					=> $tv_shows ? $tv_shows : '',
			// 'food_i_cook'				=> $this->food_i_cook ? $this->food_i_cook : '',
			// 'horoscope_privacy'			=> $horoscope_privacy ? $horoscope_privacy : '',

			'question_match'			=> $question_match ? (string)$question_match : '0',
			'is_friend'					=> $is_friend ? (string) $is_friend : '0',
			'is_request_sent'			=> $is_request_sent ? (string)$is_request_sent : '0',
			'is_request_received'		=> $is_request_received ? (string)$is_request_received : '0',
			'is_blocked'				=> $is_blocked ? (string)$is_blocked : '0',
		];
	}
}
