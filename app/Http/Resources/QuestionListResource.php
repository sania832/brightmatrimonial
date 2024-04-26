<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Auth;
use App\Models\QuestionAnswer;

class QuestionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$is_answerd = QuestionAnswer::where(['user_id'=>Auth::user()->id, 'question_id'=>$this->id])->count();
		$question = '';
		if(Auth::user()->gender == 'Male'){
			$question = $this->Male;
		}else if(Auth::user()->gender == 'Female'){
			$question = $this->Female;
		}
		
        return [
            'id'            => (string) $this->id,
            'slug'       	=> $this->slug ? (string) $this->slug : '',
            'question'		=> $question,
            'is_answerd'	=> $is_answerd ? 1 : 0,
            'options'		=> $this->options ? QuestionOptionListResource::collection($this->options) : null,
        ];
    }
}
