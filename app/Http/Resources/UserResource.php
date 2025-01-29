<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Auth;
use App\Models\ViewedMatchesHistory;
use App\Models\Interested;
use App\Models\QuestionAnswer;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
		$viewed_matches			= ViewedMatchesHistory::where('user_id','=',Auth::user()->id)->count();
		$my_matches 			= '0';
		$interested 			= Interested::where('user_id','=',Auth::user()->id)->count();
		$is_questions_submited	= QuestionAnswer::where('user_id','=',Auth::user()->id)->count();
		
		$is_step_complete 		= 'No';
		if($this->step_complete >= 7){ $is_step_complete = 'Yes'; }
        
        // return parent::toArray($request);
        return [
            'id'            		=> (string)$this->id,
            'name'          		=> $this->name,
            'profile_image'			=> $this->profile_image ? (string) asset('bright-metromonial/public/' . $this->profile_image) : asset('default/default-user.jpg'),
            'cover_image'			=> $this->cover_image ? (string) asset('bright-metromonial/public/' . $this->cover_image) : asset('default/default-user.jpg'),
            'gender'        		=> $this->gender ? $this->gender : '',
            'dob'           		=> $this->dob ? date('d-m-Y', strtotime($this->dob)) : '',
            'email'         		=> $this->email,
            'phone_number'  		=> $this->phone_number,
            'user_type'  			=> $this->user_type ? $this->user_type : '',
            'viewed_matches'		=> $viewed_matches ? (string)$viewed_matches : '0',
            'my_matches'			=> $my_matches ? (string)$my_matches : '0',
            'interested'			=> $interested ? (string)$interested : '0',
            'is_approved'  			=> $this->is_approved ? '1' : '0',
            'is_verified'  			=> $this->email_verified_at ? '1' : '0',
            'is_questions_submited'	=> $is_questions_submited ? (string)$is_questions_submited : '0',
            'active_plan'			=> $this->active_plan ? $this->active_plan : '0',
            'is_plan_expired'		=> $this->is_plan_expired ? $this->is_plan_expired : '0',
			'profile_steps'			=> $this->step_complete ? (string)$this->step_complete : '0',
            'is_step_complete'		=> $is_step_complete,
            'status'        		=> $this->status,
            'bio_data'        		=> $this->bio_data ? $this->bio_data : (object)[],
        ];
    } 
}
