<?php

namespace App\Http\Resources\theme;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Option;
use App\Models\Language;
use App\Models\City;

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
		$community 				= Option::where('id','=',$this->community)->pluck('title')->first();
		$mother_tongue 			= Language::where('id','=',$this->mother_tongue)->pluck('title')->first();
		$city 					= City::where('id','=',$this->mother_tongue)->pluck('name')->first();
		$income 				= Option::where('id','=',$this->income)->pluck('title')->first();
		$position 				= Option::where('id','=',$this->position)->pluck('title')->first();
		$religion				= Option::where('id','=',$this->religion)->pluck('title')->first();
		$cast 					= Option::where('id','=',$this->cast)->pluck('title')->first();
		$sub_cast				= Option::where('id','=',$this->sub_cast)->pluck('title')->first();
		$father_occupation		= Option::where('id','=',$this->father_occupation)->pluck('title')->first();
		$family_living_in		= City::where('id','=',$this->family_living_in)->pluck('name')->first();
		
		$sexual_orientation		= Option::where('id','=',$this->sexual_orientation)->pluck('title')->first();
		$hobbies				= Option::where('id','=',$this->hobbies)->pluck('title')->first();
		$interest				= Option::where('id','=',$this->interest)->pluck('title')->first();
		$ug_digree				= Option::where('id','=',$this->ug_digree)->pluck('title')->first();
		$pg_digree				= Option::where('id','=',$this->pg_digree)->pluck('title')->first();
		$highest_qualification	= Option::where('id','=',$this->highest_qualification)->pluck('title')->first();
		$occupation				= Option::where('id','=',$this->occupation)->pluck('title')->first();
		$company_position		= Option::where('id','=',$this->company_position)->pluck('title')->first();
		$favorite_music			= Option::where('id','=',$this->favorite_music)->pluck('title')->first();
		$favorite_books			= Option::where('id','=',$this->favorite_books)->pluck('title')->first();
		$dress_style			= Option::where('id','=',$this->dress_style)->pluck('title')->first();
		$favorite_movies		= Option::where('id','=',$this->favorite_movies)->pluck('title')->first();
		$favorite_sports		= Option::where('id','=',$this->favorite_sports)->pluck('title')->first();
		$cuisine				= Option::where('id','=',$this->cuisine)->pluck('title')->first();
		$sun_sign				= Option::where('id','=',$this->sun_sign)->pluck('title')->first();
		$rashi					= Option::where('id','=',$this->rashi)->pluck('title')->first();
		$nakshtra				= Option::where('id','=',$this->nakshtra)->pluck('title')->first();


		// return parent::toArray($request);
		return [
            'id'                		=> (string) $this->id,
            'religion'             		=> $religion ? $religion : '',
            'community'					=> $community ? $community : '',
            'mother_tongue'             => $mother_tongue ? $mother_tongue : '',
            'city'             			=> $city ? $city : '',
            'live_with_family'			=> $this->live_with_family ? $this->live_with_family : '',
            'marital_status'			=> $this->marital_status ? $this->marital_status : '',
            'diet'						=> $this->diet ? $this->diet : '',
            'height'					=> $this->height ? $this->height : '',
            'horoscope_require'			=> $this->horoscope_require ? $this->horoscope_require : '',
            'manglik'					=> $this->manglik ? $this->manglik : '',
            'highest_qualification'		=> $highest_qualification ? $highest_qualification : '',
            'company_name'				=> $this->company_name ? $this->company_name : '',
            'income_type'				=> $this->income_type ? $this->income_type : '',
            'income'					=> $income ? $income : '',
            'position'					=> $position ? $position : '',
            'cast'						=> $cast ? $cast : '',
            'sub_cast'					=> $sub_cast ? $sub_cast : '',
            'family_type'				=> $this->family_type ? $this->family_type : '',
            'father_occupation'			=> $father_occupation ? $father_occupation : '',
            'brother'					=> $this->brother ? $this->brother : '',
            'sister'					=> $this->sister ? $this->sister : '',
            'family_living_in'			=> $family_living_in ? $family_living_in : '',
            'family_bio'				=> $this->family_bio ? $this->family_bio : '',
            'family_address'			=> $this->family_address ? $this->family_address : '',
            'family_contact_no'			=> $this->family_contact_no ? $this->family_contact_no : '',
            'about'						=> $this->about ? $this->about : '',
            'country_code'				=> $this->country_code ? $this->country_code : '',
            'mobile_no'					=> $this->mobile_no  ? $this->mobile_no  : '',
            'document_type'				=> $this->document_type  ? $this->document_type  : '',
            'document_number'			=> $this->document_number  ? $this->document_number  : '',
            'document'					=> $this->document ? (string) asset('public/'. $this->document) : asset('public/'. config('constants.DEFAULT_THUMBNAIL')),
            
			'sexual_orientation'		=> $sexual_orientation ? $sexual_orientation : '',
			'hobbies'					=> $hobbies ? $hobbies : '',
			'interest'					=> $interest ? $interest : '',
			'ug_digree'					=> $ug_digree ? $ug_digree : '',
			'pg_digree'					=> $pg_digree ? $pg_digree : '',
			'highest_qualification'		=> $highest_qualification ? $highest_qualification : '',
			'occupation'				=> $occupation ? $occupation : '',
			'company_position'			=> $company_position ? $company_position : '',
			'favorite_music'			=> $favorite_music ? $favorite_music : '',
			'favorite_books'			=> $favorite_books ? $favorite_books : '',
			'dress_style'				=> $dress_style ? $dress_style : '',
			'favorite_movies'			=> $favorite_movies ? $favorite_movies : '',
			'favorite_sports'			=> $favorite_sports ? $favorite_sports : '',
			'cuisine'					=> $cuisine ? $cuisine : '',
			'sun_sign'					=> $sun_sign ? $sun_sign : '',
			'rashi'						=> $rashi ? $rashi : '',
			'nakshtra'					=> $nakshtra ? $nakshtra : '',
		];
	}
}
