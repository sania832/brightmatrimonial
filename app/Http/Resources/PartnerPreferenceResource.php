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

class PartnerPreferenceResource extends JsonResource
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
		$qualification			= Option::where('id','=',$this->qualification)->pluck('title')->first();
		$height					= Option::where('id','=',$this->height)->pluck('title')->first();
		$religion				= Option::where('id','=',$this->religion)->pluck('title')->first();
		$community 				= Option::where('id','=',$this->community)->pluck('title')->first();
		$marital_status 		= Option::where('id','=',$this->marital_status)->pluck('title')->first();
		$mother_tongue			= Option::where('id','=',$this->mother_tongue)->pluck('title')->first();
		$city 					= City::where('id','=',$this->city_living_in)->pluck('name')->first();
		$state 					= State::where('id','=',$this->state_living_in)->pluck('name')->first();
		$company_position		= Option::where('id','=',$this->profession_area)->pluck('title')->first();
		$working_with			= Option::where('id','=',$this->working_with)->pluck('title')->first();
		$income 				= Option::where('id','=',$this->income)->pluck('title')->first();
		$diet 					= Option::where('id','=',$this->diet)->pluck('title')->first();
		$profession_area 					= City::where('id','=',$this->profession_area)->pluck('name')->first();

		// return parent::toArray($request);
		return [
            'id'                		=> (string) $this->id,
            'looking_for'         		=> (string) $this->looking_for,
            'start_age'					=> $this->start_age ? (string)$this->start_age : '',
            'end_age'					=> $this->end_age ? (string)$this->end_age : '',
            // 'height'					=> $height ? $height : '',
            // 'marital_status'			=> $marital_status ? $marital_status : '',
            'religion'					=> $religion ? $religion : '',
            // 'community'					=> $community ? $community : '',
            'mother_tongue'				=> $mother_tongue ? $mother_tongue : '',
            // 'state_living_in'			=> $state ? $state : '',
            // 'city_living_in'			=> $city ? $city : '',
            // 'qualification'				=> $qualification ? $qualification : '',
            // 'working_with'				=> $working_with ? $working_with : '',
            // 'profession_area'			=> $profession_area ? $profession_area : '',
            // 'income'					=> $income ? $income : '',
            // 'diet'						=> $diet ? $diet : '',
		];
	}
}
