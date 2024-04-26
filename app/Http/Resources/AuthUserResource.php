<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$is_step_complete 		= 'No';
		if($this->step_complete >= 7){ $is_step_complete = 'Yes'; }

		// return parent::toArray($request);
        return [
            'id'            		=> (string)$this->id,
            'token'          		=> $this->token ? $this->token : '',
            'name'          		=> $this->name ? $this->name : '',
            'first_name'			=> $this->first_name ? $this->first_name : '',
            'last_name'				=> $this->last_name ? $this->last_name : '',
            'email'         		=> $this->email ? $this->email : '',
            'profile_image'			=> $this->profile_image ? (string) asset('data/public/'. $this->profile_image) : asset('default/default-user.jpg'),
            'cover_image'			=> $this->cover_image ? (string) asset('data/public/'. $this->cover_image) : asset('default/default-user.jpg'),
            'gender'        		=> $this->gender ? $this->gender : '',
            'dob'           		=> $this->dob ? $this->dob : '',
            'country_code'  		=> $this->country_code ? $this->country_code : '',
            'phone_number'  		=> $this->phone_number ? $this->phone_number : '',
            'profile_for'  			=> $this->profile_for ? $this->profile_for : '',
            'user_type'  			=> $this->user_type ? $this->user_type : '',
            'completed_step'		=> $this->completed_step ? $this->completed_step : '',
            'bio_data'				=> $this->bio_data ? $this->bio_data : '',
            'is_approved'  			=> $this->is_approved ? '1' : '0',
            'is_verified'  			=> $this->email_verified_at ? '1' : '0',
            'is_questions_submited'	=> $this->is_questions_submited ? '1' : '0',
            'active_plan'			=> $this->active_plan ? $this->active_plan : '',
			'profile_steps'			=> $this->step_complete ? (string)$this->step_complete : '0',
            'is_step_complete'		=> $is_step_complete,
            'status'        		=> $this->status,
        ];
    }
}
