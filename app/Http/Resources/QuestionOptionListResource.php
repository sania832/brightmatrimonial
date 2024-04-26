<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Auth;
use App\Models\QuestionAnswer;

class QuestionOptionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$is_answerd = QuestionAnswer::where(['user_id'=>Auth::user()->id, 'answer_id'=>$this->id])->count();
		$option = '';
		if(Auth::user()->gender == 'Male'){
			$option = $this->Male;
		}else if(Auth::user()->gender == 'Female'){
			$option = $this->Female;
		}
		
        return [
            'id'            => (string) $this->id,
            'type'       	=> $this->type ? (string) $this->type : '',
            'option'       	=> $option,
            'is_answerd'	=> $is_answerd ? 1 : 0,
        ];
    }
}
